<?php

namespace App\Http\Controllers\Cases;

use App\DataTables\CaseDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CaseEditRequest;
use App\Http\Requests\CaseRequest;
use App\Models\Cases;
use App\Models\Client;
use App\Models\User;
use App\Services\CaseService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CaseController extends Controller
{
    protected $caseService;

    public function __construct(CaseService $caseService)
    {
        $this->caseService = $caseService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CaseDataTable $dataTable)
    {
        set_page_meta('Case');
        return $dataTable->render('admin.cases.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        return view('admin.cases.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CaseRequest $request)
    {
        $data = $request->validated();

        try {
            $this->caseService->storeOrUpdate($data, null);

        } catch (\Exception $e) {
        }
        record_created_flash();
        return redirect()->route('admin.cases.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        set_page_meta('Details');
        $case = Cases::find($id);
        return view('admin.cases.show',compact('case'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $case = Cases::find($id);
        return view('admin.cases.edit', compact('case'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CaseEditRequest $request, string $id)
    {
        $data = $request->validated();
        $this->caseService->storeOrUpdate($data, $id);
        record_created_flash();
        try {


        } catch (\Exception $e) {
        }
        return redirect()->route('admin.cases.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->caseService->delete($id);
            record_deleted_flash();
            return back();
        } catch (\Exception $e) {
            return back();
        }
    }

    // public function downloadCasePdf($id){
    //     $data = Cases::find($id);
    //     $pdf = Pdf::loadView('admin.cases.export-pdf', compact('data'));
    //     return $pdf->stream('cases.pdf');
    // }

    public function casesShowtoClient(){
        $cases = Cases::where('client_id', Auth::user()->id)->get();
        return view('admin.cases.show-to-client', compact('cases'));
    }
}
