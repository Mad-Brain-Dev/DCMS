<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\DataTables\InvoiceDataTable;
use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Models\Cases;
use App\Models\Client;
use App\Models\Installment;
use App\Models\Invoice;
use App\Services\InvoiceNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(InvoiceDataTable $dataTable, Request $request)
    {
        set_page_meta('Invoices');
        $selectedMonth = request('month') ?? \Carbon\Carbon::now()->format('Y-m');
        // Filters
        $clients = Client::orderBy('name')->get();

        $from = $request->from;
        $to = $request->to;
        $clientId = $request->client_id;
        $status = $request->status;

        // Summary Cards (Global Overview)
        $summaryQuery = Invoice::query();

        if ($from && $to) {
            $summaryQuery->whereBetween('issued_date', [$from, $to]);
        }

        if ($clientId) {
            $summaryQuery->where('client_id', $clientId);
        }

        if ($status) {
            $summaryQuery->where('status', $status);
        }

        if ($selectedMonth) {
            $year = \Carbon\Carbon::parse($selectedMonth)->year;
            $month = \Carbon\Carbon::parse($selectedMonth)->month;

            $summaryQuery->whereYear('issued_date', $year)
                ->whereMonth('issued_date', $month);
        }

        $totalInvoices = (clone $summaryQuery)
            ->where('status', '!=', 'cancelled')
            ->count();

        $totalCollected = (clone $summaryQuery)
            ->where('status', '!=', 'cancelled')
            ->sum(DB::raw('total_collected_client + total_collected_securre'));

        $totalFinalAmount = (clone $summaryQuery)
            ->where('status', '!=', 'cancelled')
            ->sum('final_invoice_amount');

        $totalOutstanding = (clone $summaryQuery)
            ->where('status', 'issued')
            ->sum('final_invoice_amount');

        $months = [];

        for ($i = 0; $i < 12; $i++) {
            $month = \Carbon\Carbon::now()->subMonths($i)->format('Y-m');
            $months[$month] = \Carbon\Carbon::now()->subMonths($i)->format('F Y');
        }

        return $dataTable->render('admin.invoices.index', compact(
            'clients',
            'totalInvoices',
            'totalCollected',
            'totalFinalAmount',
            'totalOutstanding',
            'selectedMonth',
            'months'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();

        return view('admin.invoices.create', compact('clients'));
    }
    public function store(Request $request, InvoiceNumberService $numberService)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'installments' => 'required|array|min:1'
        ]);

        return DB::transaction(function () use ($request, $numberService) {

            $client = Client::findOrFail($request->client_id);

            // Lock installments to prevent double invoicing
            $installments = Installment::whereIn('id', $request->installments)
                ->where('is_invoiced', false)
                ->lockForUpdate()
                ->get();

            if ($installments->count() === 0) {
                return redirect()->back()->with('error', 'No valid installments found.');
            }

            $commissionRate = (float) $client->collection_commission;

            // =========================
            // FINANCIAL CALCULATION
            // =========================

            $totalCollectedClient = 0;
            $totalCollectedSecurre = 0;
            $payableToClient = 0;
            $payableToSecurre = 0;

            foreach ($installments as $installment) {

                $amount = (float) $installment->amount_paid;
                $commissionAmount = $amount * ($commissionRate / 100);

                if ($installment->pay_to_who === 'client') {

                    // Client collected → owes commission to Securre
                    $totalCollectedClient += $amount;
                    $payableToSecurre += $commissionAmount;

                } else {

                    // Securre collected → client receives net
                    $totalCollectedSecurre += $amount;
                    $payableToClient += ($amount - $commissionAmount);
                }
            }

            // =========================
            // FINAL SETTLEMENT
            // =========================

            if ($payableToClient > $payableToSecurre) {

                $finalInvoiceAmount = $payableToClient - $payableToSecurre;
                $finalPayableTo = 'client';

            } else {

                $finalInvoiceAmount = $payableToSecurre - $payableToClient;
                $finalPayableTo = 'securre';
            }

            // =========================
            // GENERATE INVOICE NUMBER
            // =========================

            $numberData = $numberService->generate($client);

            // =========================
            // CREATE INVOICE
            // =========================

            $invoice = Invoice::create([
                'invoice_number' => $numberData['invoice_number'],
                'year' => $numberData['year'],
                'sequence_number' => $numberData['sequence_number'],
                'client_id' => $client->id,

                'invoice_date' => now(),
                'issued_date' => now(),

                'total_collected_client' => $totalCollectedClient,
                'total_collected_securre' => $totalCollectedSecurre,

                'payable_to_client' => $payableToClient,
                'payable_to_securre' => $payableToSecurre,

                'final_invoice_amount' => $finalInvoiceAmount,
                'final_payable_to' => $finalPayableTo,

                'status' => 'issued',
            ]);

            // =========================
            // INSERT PIVOT SNAPSHOT
            // =========================

            foreach ($installments as $installment) {

                $amount = (float) $installment->amount_paid;
                $commissionAmount = $amount * ($commissionRate / 100);

                if ($installment->pay_to_who === 'client') {

                    // Client collected → commission goes to Securre
                    $netAmount = $commissionAmount;

                } else {

                    // Securre collected → net goes to client
                    $netAmount = $amount - $commissionAmount;
                }

                $invoice->installments()->attach($installment->id, [

                    'amount_paid' => $amount,
                    'commission_rate' => $commissionRate,
                    'commission_amount' => $commissionAmount,
                    'net_amount' => $netAmount,

                    // SNAPSHOT FIELDS (CRITICAL)
                    'total_debt_snapshot' => $installment->snapshot_total_debt ?? 0,
                    'balance_snapshot' => $installment->snapshot_total_balance ?? 0,

                    'collected_type' => $installment->pay_to_who,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Mark installment as invoiced
                $installment->is_invoiced = true;
                $installment->save();
            }

            record_created_flash('Invoice generated successfully.');

            return redirect()
                ->route('admin.invoices.show', $invoice->id)
                ->with('success', 'Invoice generated successfully.');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load([
            'client',
            'installments.case',
            'installments.debtor'
        ]);

        $securreBank = BankDetail::first(); // assuming single tenant

        $client = $invoice->client;

        // Split installments by collected type
        $collectedByClient = $invoice->installments
            ->where('pivot.collected_type', 'client');

        $collectedBySecurre = $invoice->installments
            ->where('pivot.collected_type', 'securre');

        return view('admin.invoices.show', compact(
            'invoice',
            'client',
            'collectedByClient',
            'collectedBySecurre',
            'securreBank'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        if ($invoice->status === 'paid') {
            return back()->with('error', 'Paid invoice cannot be cancelled.');
        }

        DB::transaction(function () use ($invoice) {

            // Get related installments
            $installmentIds = $invoice->installments()->pluck('installment_id');

            // Unlock installments
            Installment::whereIn('id', $installmentIds)
                ->update(['is_invoiced' => false]);

            // Delete pivot records
            $invoice->installments()->detach();

            // Mark invoice as cancelled
            $invoice->update([
                'status' => 'cancelled',
                'cancelled_by' => Auth::user()->id,
                'cancelled_at' => now()
            ]);
        });

        return back()->with('success', 'Invoice cancelled successfully.');
    }

    public function getClientInstallments(Request $request)
    {
        $clientId = $request->client_id;

        $client = Client::findOrFail($clientId);

        // Load all installments for this client
        $installments = Installment::with(['case', 'debtor', 'collectedBy'])
            ->whereHas('case', function ($q) use ($clientId) {
                $q->where('client_id', $clientId);
            })
            ->where('update_type', 'field_visit_update')
            ->orderBy('date_of_payment')
            ->get();

        // =========================
        // Banner Calculations
        // =========================

        $totalCollected = $installments->sum('amount_paid');

        $totalBalance = Cases::where('client_id', $clientId)
            ->sum('total_amount_balance');

        // =========================
        // Format Installments
        // =========================

        $formattedInstallments = $installments->map(function ($item) {

            return [
                'id' => $item->id,
                'is_invoiced' => $item->is_invoiced,

                'amount_paid' => $item->amount_paid,
                'pay_to_who' => formatPaidTo($item->pay_to_who),

                'debtor' => optional($item->debtor)->name ?? '-',
                'collectedBy' => optional($item->collectedBy)->name ?? '-',

                'date_of_payment' => optional($item->date_of_payment)->format('d M Y'),
                'next_payment_date' => optional($item->next_payment_date)->format('d M Y'),

                'case' => [
                    'case_number' => $item->case->case_sku ?? '-',

                    // SNAPSHOT VALUES (IMPORTANT)
                    'snapshot_total_paid' => $item->snapshot_total_paid ?? 0,
                    'snapshot_total_balance' => $item->snapshot_total_balance ?? 0,
                    'snapshot_total_debt' => $item->snapshot_total_debt ?? 0,
                ]
            ];
        });

        return response()->json([
            'data' => $formattedInstallments,
            'banner' => [
                'client_name' => $client->name,
                'payment_count' => $installments->count(),
                'total_collected' => $totalCollected,
                'total_balance' => $totalBalance,
            ]
        ]);
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate([
            'status' => 'required|in:issued,paid,cancelled',
            'paid_date' => 'nullable|date',
            'issued_date' => 'nullable|date',
        ]);

        $data = [
            'status' => $request->status,
        ];

        if ($request->status === 'paid') {
            $data['paid_at'] = $request->paid_date ?? now();
        }

        if ($request->status === 'issued') {
            $data['issued_date'] = $request->issued_date ?? now();
        }

        if ($request->status === 'cancelled') {
            $data['paid_at'] = null;
        }

        $invoice->update($data);

        return redirect()->back()
            ->with('success', 'Invoice status updated successfully.');
    }


}
