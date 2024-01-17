<?php

namespace App\Http\Controllers\Debtor;

use App\DataTables\DebtorDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\DebtorRequest;
use App\Models\User;
use App\Services\DebtorService;
use Illuminate\Http\Request;

class DebtorController extends Controller
{
    protected $debtorService;

    public function __construct(DebtorService $debtorService)
    {
        $this->debtorService = $debtorService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(DebtorDataTable $dataTable)
    {
        set_page_meta('Debtor');
        return $dataTable->render('admin.debtors.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.debtors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DebtorRequest $request)
    {

        $data = $request->validated();
        $this->debtorService->storeOrUpdate($data, null);
            record_created_flash();
        try {

        } catch (\Exception $e) {
        }
        return redirect()->route('admin.debtors.index');

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
        $debtors = User::find($id);
        return view('admin.debtors.edit', compact('debtors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DebtorRequest $request, string $id)
    {
        $data = $request->validated();
        $this->debtorService->storeOrUpdate($data, $id);
            record_created_flash();
        try {

        } catch (\Exception $e) {
        }
        return redirect()->route('admin.debtors.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
