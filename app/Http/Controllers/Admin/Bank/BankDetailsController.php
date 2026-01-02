<?php

namespace App\Http\Controllers\Admin\Bank;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use App\Services\BankDetailService;
use Illuminate\Http\Request;

class BankDetailsController extends Controller
{
    protected $bankDetailService;

    public function __construct(BankDetailService $bankDetailService)
    {
        $this->bankDetailService = $bankDetailService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        set_page_meta('Bank Details');

        $detail = BankDetail::where('tenant_id', $id)->first();

        return view('admin.bank_details.edit', compact('detail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'account_name' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'bank_code' => 'required',
            'branch_code' => 'required',
            'bank_address' => 'required',
            'swift_code' => 'required',
            'payment_methods' => 'required',
            'payment_terms' => 'required',
        ]);
        $detail = BankDetail::where('tenant_id', $id)->first();
        $this->bankDetailService->storeOrUpdate($validatedData, $detail->id);
        try {

            record_updated_flash();
        } catch (\Exception $e) {
            return back();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
