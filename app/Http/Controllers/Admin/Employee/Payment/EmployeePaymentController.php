<?php

namespace App\Http\Controllers\Admin\Employee\Payment;

use App\DataTables\EmployeePaymentDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeCommission;
use App\Models\EmployeePayment;
use App\Models\Cases;
use Illuminate\Support\Facades\DB;

class EmployeePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EmployeePaymentDataTable $dataTable)
    {
        set_page_meta('Employee Payments');

        $selectedMonth = request('month') ?? \Carbon\Carbon::now()->format('Y-m');
        $totalGenerated = EmployeeCommission::sum('commission_amount');

        $totalPaid = EmployeePayment::sum('amount');

        $totalPending = $totalGenerated - $totalPaid;

        $monthGenerated = EmployeeCommission::where('commission_month', $selectedMonth)
            ->sum('commission_amount');

        $monthPaid = EmployeePayment::where('month', $selectedMonth)
            ->sum('amount');

        $thisMonthPayable = $monthGenerated - $monthPaid;

        $pendingEmployeeCount = EmployeeCommission::where('commission_month', $selectedMonth)
            ->select('employee_id')
            ->groupBy('employee_id')
            ->get()
            ->filter(function ($row) use ($selectedMonth) {

                $earned = EmployeeCommission::where('commission_month', $selectedMonth)
                    ->where('employee_id', $row->employee_id)
                    ->sum('commission_amount');

                $paid = EmployeePayment::where('month', $selectedMonth)
                    ->where('employee_id', $row->employee_id)
                    ->sum('amount');

                return ($earned - $paid) > 0;
            })
            ->count();

//        $months = [];
//
//        for ($i = 0; $i < 12; $i++) {
//            $month = \Carbon\Carbon::now()->subMonths($i)->format('Y-m');
//            $months[$month] = \Carbon\Carbon::now()->subMonths($i)->format('F Y');
//        }

        return $dataTable->render('admin.employees.payment.index', compact(
            'totalGenerated',
            'totalPaid',
            'totalPending',
            'monthGenerated',
            'monthPaid',
            'thisMonthPayable',
            'pendingEmployeeCount',
            'selectedMonth',
//            'months'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        set_page_meta('Employee Payment Details');
        $employee = Employee::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Lifetime Summary
        |--------------------------------------------------------------------------
        */

        $totalEarned = EmployeeCommission::where('employee_id', $employee->id)
            ->sum('commission_amount');

        $totalPaid = EmployeePayment::where('employee_id', $employee->id)
            ->sum('amount');

        $totalDue = $totalEarned - $totalPaid;

        /*
        |--------------------------------------------------------------------------
        | Assigned Cases
        |--------------------------------------------------------------------------
        */

        $assignedCases = Cases::where(function ($q) use ($employee) {
            $q->where('assigned_to_id', $employee->id)
                ->orWhere('manager_ic', $employee->id)
                ->orWhere('collector_ic', $employee->id);
        })->latest()->get();

        // Monthly Breakdown

        $filter = request('range', '6'); // default 6 months

        $commissionQuery = DB::table('employee_commissions')
            ->where('employee_id', $employee->id);

        if ($filter === '6') {
            $commissionQuery->where('commission_month', '>=', now()->subMonths(5)->format('Y-m'));
        }

        if ($filter === '12') {
            $commissionQuery->where('commission_month', '>=', now()->subMonths(11)->format('Y-m'));
        }

        $commissionSummary = $commissionQuery
            ->select(
                'commission_month',
                DB::raw('SUM(commission_amount) as total_commission')
            )
            ->groupBy('commission_month')
            ->orderByDesc('commission_month')
            ->get();

        $monthlyBreakdown = $commissionSummary->map(function ($row) use ($employee) {

            $paid = DB::table('employee_payments')
                ->where('employee_id', $employee->id)
                ->where('month', $row->commission_month)
                ->sum('amount');

            $due = $row->total_commission - $paid;

            return (object)[
                'month'            => $row->commission_month,
                'total_commission' => $row->total_commission,
                'total_paid'       => $paid,
                'due'              => $due,
                'status'           => $due > 0 ? 'Pending' : 'Paid',
                'progress'         => $row->total_commission > 0
                    ? round(($paid / $row->total_commission) * 100)
                    : 0,
            ];
        });


        return view('admin.employees.payment.show', compact(
            'employee',
            'totalEarned',
            'totalPaid',
            'totalDue',
            'assignedCases',
            'monthlyBreakdown',
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
        //
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'month' => 'required',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Calculate Current Month Earned & Paid (Before Payment)
        |--------------------------------------------------------------------------
        */

        $earned = \App\Models\EmployeeCommission::where('employee_id', $request->employee_id)
            ->where('commission_month', $request->month)
            ->sum('commission_amount');

        $paid = \App\Models\EmployeePayment::where('employee_id', $request->employee_id)
            ->where('month', $request->month)
            ->sum('amount');

        $paymentAmount = $request->amount;

        // Convert to cents (safe decimal handling)
        $earnedCents = (int) round($earned * 100);
        $paidCents = (int) round($paid * 100);
        $paymentCents = (int) round($paymentAmount * 100);

        $dueCents = $earnedCents - $paidCents;

        if ($paymentCents > $dueCents) {
            return response()->json([
                'success' => false,
                'message' => 'Payment exceeds due amount.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | Save Payment
        |--------------------------------------------------------------------------
        */

        \App\Models\EmployeePayment::create([
            'employee_id' => $request->employee_id,
            'month' => $request->month,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'note' => $request->note,
            'created_by' => auth()->id(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Recalculate Month Summary After Payment
        |--------------------------------------------------------------------------
        */

        $totalCommission = \App\Models\EmployeeCommission::where('employee_id', $request->employee_id)
            ->where('commission_month', $request->month)
            ->sum('commission_amount');

        $totalPaid = \App\Models\EmployeePayment::where('employee_id', $request->employee_id)
            ->where('month', $request->month)
            ->sum('amount');

        $due = $totalCommission - $totalPaid;

        $progress = $totalCommission > 0
            ? round(($totalPaid / $totalCommission) * 100)
            : 0;

        $status = $due > 0 ? 'Pending' : 'Paid';

        /*
        |--------------------------------------------------------------------------
        | Update Commission Status If Fully Paid
        |--------------------------------------------------------------------------
        */

        if ($status === 'Paid') {
            \App\Models\EmployeeCommission::where('employee_id', $request->employee_id)
                ->where('commission_month', $request->month)
                ->update(['status' => 'paid']);
        }

        /*
        |--------------------------------------------------------------------------
        | Lifetime Summary Update
        |--------------------------------------------------------------------------
        */

        $totalEarned = \App\Models\EmployeeCommission::where('employee_id', $request->employee_id)
            ->sum('commission_amount');

        $lifetimePaid = \App\Models\EmployeePayment::where('employee_id', $request->employee_id)
            ->sum('amount');

        $lifetimeDue = $totalEarned - $lifetimePaid;

        /*
        |--------------------------------------------------------------------------
        | JSON Response For Live UI Update
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'message' => 'Payment recorded successfully.',
            'monthData' => [
                'month' => $request->month,
                'total_commission' => $totalCommission,
                'total_paid' => $totalPaid,
                'due' => $due,
                'progress' => $progress,
                'status' => $status,
            ],
            'lifetime' => [
                'earned' => $totalEarned,
                'paid' => $lifetimePaid,
                'due' => $lifetimeDue,
            ]
        ]);
    }


    public function summary(Request $request)
    {
        $selectedMonth = $request->month ?? now()->format('Y-m');

        /*
        |--------------------------------------------------------------------------
        | Lifetime Totals
        |--------------------------------------------------------------------------
        */

        $totalGenerated = EmployeeCommission::sum('commission_amount');

        $totalPaid = EmployeePayment::sum('amount');

        $totalPending = $totalGenerated - $totalPaid;


        /*
        |--------------------------------------------------------------------------
        | Monthly Totals
        |--------------------------------------------------------------------------
        */

        $monthGenerated = EmployeeCommission::where('commission_month', $selectedMonth)
            ->sum('commission_amount');

        $monthPaid = EmployeePayment::where('month', $selectedMonth)
            ->sum('amount');

        $thisMonthPayable = $monthGenerated - $monthPaid;


        /*
        |--------------------------------------------------------------------------
        | Employees Pending (Optimized)
        |--------------------------------------------------------------------------
        */

        $commissionSub = DB::table('employee_commissions')
            ->select(
                'employee_id',
                DB::raw('SUM(commission_amount) as total_earned')
            )
            ->where('commission_month', $selectedMonth)
            ->groupBy('employee_id');

        $paymentSub = DB::table('employee_payments')
            ->select(
                'employee_id',
                DB::raw('SUM(amount) as total_paid')
            )
            ->where('month', $selectedMonth)
            ->groupBy('employee_id');

        $pendingEmployeeCount = DB::query()
            ->fromSub($commissionSub, 'c')
            ->leftJoinSub($paymentSub, 'p', function ($join) {
                $join->on('c.employee_id', '=', 'p.employee_id');
            })
            ->whereRaw('c.total_earned > COALESCE(p.total_paid, 0)')
            ->count();




        return response()->json([
            // Lifetime
            'totalGenerated' => number_format($totalGenerated, 2),
            'totalPaid' => number_format($totalPaid, 2),
            'totalPending' => number_format($totalPending, 2),

            // Monthly
            'monthGenerated' => number_format($monthGenerated, 2),
            'monthPaid' => number_format($monthPaid, 2),
            'thisMonthPayable' => number_format($thisMonthPayable, 2),
            'pendingEmployeeCount' => $pendingEmployeeCount,
        ]);
    }

    public function monthlyBreakdownAjax(Request $request, Employee $employee)
    {
        $range = $request->range ?? 6;

        $query = DB::table('employee_commissions')
            ->where('employee_id', $employee->id);

        if ($range != 'all') {
            $months = now()->subMonths($range)->format('Y-m');
            $query->where('commission_month', '>=', $months);
        }

        $commissions = $query
            ->select(
                'commission_month as month',
                DB::raw('SUM(commission_amount) as total_commission')
            )
            ->groupBy('commission_month')
            ->orderByDesc('commission_month')
            ->get();

        $monthlyBreakdown = $commissions->map(function ($row) use ($employee) {

            $paid = EmployeePayment::where('employee_id', $employee->id)
                ->where('month', $row->month)
                ->sum('amount');

            $row->total_paid = $paid;
            $row->due = $row->total_commission - $paid;
            $row->status = $row->due > 0 ? 'Pending' : 'Paid';
            $row->progress = $row->total_commission > 0
                ? round(($paid / $row->total_commission) * 100)
                : 0;

            return $row;
        });

        return response()->json($monthlyBreakdown);
    }

    public function paymentHistory(Request $request, Employee $employee)
    {
        $perPage = 10;

        $totalEarned = EmployeeCommission::where('employee_id', $employee->id)
            ->sum('commission_amount');

        $payments = EmployeePayment::where('employee_id', $employee->id)
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->paginate($perPage);

        $totalPaid = EmployeePayment::where('employee_id', $employee->id)
            ->sum('amount');

        $totalTransactions = EmployeePayment::where('employee_id', $employee->id)
            ->count();

        $lastPayment = EmployeePayment::where('employee_id', $employee->id)
            ->latest('payment_date')
            ->first();

        $lifetimeDue = $totalEarned - $totalPaid;

        $data = [];

        foreach ($payments as $payment) {

            // Sum of all payments up to this payment (by date & id)
            $paidUntilNow = EmployeePayment::where('employee_id', $employee->id)
                ->where(function ($q) use ($payment) {
                    $q->where('payment_date', '<', $payment->payment_date)
                        ->orWhere(function ($q2) use ($payment) {
                            $q2->where('payment_date', '=', $payment->payment_date)
                                ->where('id', '<=', $payment->id);
                        });
                })
                ->sum('amount');

            $runningBalance = $totalEarned - $paidUntilNow;

            $data[] = [
                'id' => $payment->id,
                'date' => \Carbon\Carbon::parse($payment->payment_date)->format('d M Y'),
                'month' => \Carbon\Carbon::createFromFormat('Y-m', $payment->month)->format('F Y'),
                'amount' => number_format($payment->amount, 2),
                'method' => $payment->payment_method,
                'note' => $payment->note,
                'running_balance' => number_format($runningBalance, 2),
            ];
        }


        return response()->json([
            'data' => $data,
            'pagination' => [
                'current_page' => $payments->currentPage(),
                'last_page' => $payments->lastPage(),
            ],
            'summary' => [
                'total_paid' => number_format($totalPaid, 2),
                'total_transactions' => $totalTransactions,
                'last_payment' => $lastPayment
                    ? \Carbon\Carbon::parse($lastPayment->payment_date)->format('d M Y')
                    : '-',
                'running_balance' => number_format($lifetimeDue, 2),
            ]
        ]);
    }


}
