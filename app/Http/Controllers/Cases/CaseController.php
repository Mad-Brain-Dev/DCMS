<?php

namespace App\Http\Controllers\Cases;

use App\DataTables\CaseDataTable;
use App\DataTables\CasesforPerticularClientDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CaseEditRequest;
use App\Http\Requests\CaseRequest;
use App\Models\Cases;
use App\Models\Client;
use App\Models\CorrespondenceUpdate;
use App\Models\FieldVisitUpdate;
use App\Models\GeneralCaseUpdate;
use App\Models\MiscellaneousUpdate;
use App\Models\User;
use App\Services\CaseService;
use App\Services\Utils\FileUploadService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CaseController extends Controller
{
    protected $caseService;

    protected $fileUploadService;

    public function __construct(CaseService $caseService, FileUploadService $fileUploadService)
    {
        $this->caseService = $caseService;
        $this->fileUploadService = $fileUploadService;
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
    public function create(Request $request)
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
        $this->caseService->storeOrUpdate($data, null);
        record_created_flash();
        try {
        } catch (\Exception $e) {
        }

        return redirect()->route('admin.cases.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        set_page_meta('Details');
        $case = Cases::find($id);
        $gn_updates = GeneralCaseUpdate::where('case_id', $id)->latest()->get();
        $cr_updates = CorrespondenceUpdate::where('case_id', $id)->latest()->get();
        $fv_updates = FieldVisitUpdate::where('case_id', $id)->latest()->get();
        $ms_updates = MiscellaneousUpdate::where('case_id', $id)->latest()->get();
        return view('admin.cases.show', compact('case', 'gn_updates','cr_updates','fv_updates','ms_updates'));
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


    //All case show to perticular client in datatable
    public function casesForPerticularClient(CasesforPerticularClientDataTable $dataTable)
    {
        set_page_meta('Case');
        return $dataTable->render('client.cases.index');
    }
    //Single case show to client
    public function casesShowtoClient()
    {
        $cases = Cases::where('client_id', Auth::user()->id)->get();
        return view('client.cases.show-to-client', compact('cases'));
    }
    //Show date of agreement from client table when create cases
    public function dateOfAgreementForCase(Request $request)
    {
        $dateofAgreement = Client::where('client_id', $request->client_id)->first();
        return response()->json([
            'status' => 'success',
            'dateofagreement' => $dateofAgreement,
        ]);
    }
    // Create Case Update
    public function generalCaseCreate(Request $request)
    {

        $request->validate([
            'gn_update' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'fv_date' => 'nullable',
            'gn_summary' => 'nullable',
            'cr_update' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'cr_summary' => 'nullable',
            'fv_update' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'fv_summary' => 'nullable',
            'ms_update' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'ms_summary' => 'nullable',
        ]);

        if ($request->gn_update) {
            $document = GeneralCaseUpdate::create([
                'case_id' => $request->case_id,
                'fv_date' => $request->fv_date,
                'gn_summary' => $request->gn_summary,
            ]);

            if ($request->hasFile('gn_update')) {
                $image = $this->fileUploadService->upload($request['gn_update'], GeneralCaseUpdate::FILE_STORE_DOCUMENT_PATH, false, true);
                $document->gn_update = $image;
                $document->save();
            }
        }

        if($request->cr_update){
            $document = CorrespondenceUpdate::create([
                'case_id' => $request->case_id,
                'fv_date' => $request->fv_date,
                'cr_summary' => $request->cr_summary,
            ]);

            if ($request->hasFile('cr_update')) {
                $image = $this->fileUploadService->upload($request['cr_update'], CorrespondenceUpdate::FILE_STORE_DOCUMENT_PATH, false, true);
                $document->cr_update = $image;
                $document->save();
            }
        }

        if($request->fv_update){
            $document = FieldVisitUpdate::create([
                'case_id' => $request->case_id,
                'fv_date' => $request->fv_date,
                'fv_summary' => $request->fv_summary,
            ]);

            if ($request->hasFile('fv_update')) {
                $image = $this->fileUploadService->upload($request['fv_update'], FieldVisitUpdate::FILE_STORE_DOCUMENT_PATH, false, true);
                $document->fv_update = $image;
                $document->save();
            }
        }

        if($request->ms_update){
            $document = MiscellaneousUpdate::create([
                'case_id' => $request->case_id,
                'fv_date' => $request->fv_date,
                'ms_summary' => $request->ms_summary,
            ]);

            if ($request->hasFile('ms_update')) {
                $image = $this->fileUploadService->upload($request['ms_update'], MiscellaneousUpdate::FILE_STORE_DOCUMENT_PATH, false, true);
                $document->ms_update = $image;
                $document->save();
            }
        }

        record_updated_flash();
        return back();
    }

    public function showSingleGeneralUpdate($id)
    {
        return $id;
    }
}
