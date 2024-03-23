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
        set_page_meta('Cases');
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
        try {
            $count = Cases::count();
            if ($count <= 0) {
                $case =  $this->caseService->storeOrUpdate($data, null);
                $case_id = $case->id;
                if ($case) {
                    $case = Cases::where('id', $case_id)->first();
                    $case->case_sku = "1";
                    $case->save();
                    if ($case) {
                        $case_number = Cases::where('id', $case_id)->first();
                        $case_number->case_number = $case_number->case_number . '000' . $case_number->case_sku;
                        $case_number->save();
                    }
                }
            } else {
                $case =  $this->caseService->storeOrUpdate($data, null);
                $case_id = $case->id;
                if ($case) {
                    $case = Cases::where('id', $case_id)->first();
                    $case->save();
                    if ($case) {
                        $case_number = Cases::where('id', $case_id)->first();
                        $case_number->case_number = $case_number->case_number . '000' . $case_number->case_sku + $case->id;
                        $case_number->save();
                    }
                }
            }
        } catch (\Exception $e) {
        }



        $client_details = Client::where('client_id', $case_number->client_id)->first();
        $total_amount_owed = $case_number->total_amount_owed; // Total value
        $portion = $client_details->collection_commission; // Portion of the total value

        // Calculate percentage
        $percentage = ($portion * $total_amount_owed) / 100;

        $total_fees = ($client_details->administrative_fee ? $client_details->administrative_fee : 0) + ($client_details->enforcement_fee ? $client_details->enforcement_fee : 0) + ($client_details->professional_fee ? $client_details->professional_fee : 0) + ($client_details->annual_fee ? $client_details->annual_fee : 0) + ($client_details->skip_tracing_fee ? $client_details->skip_tracing_fee : 0) + ($client_details->overseas_allowance ? $client_details->overseas_allowance : 0) + $percentage;

        return view('admin.agreement.agreement', compact('case_number', 'client_details', 'total_fees'));
        //  return redirect()->route('printable.case.agreement', $case_number->id);
        record_created_flash();
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        set_page_meta('Details');
        $case = Cases::find($id);
        $client_details = Client::where('client_id', $case->client_id)->first();
        $gn_updates = GeneralCaseUpdate::where('case_id', $id)->latest()->get();
        $cr_updates = CorrespondenceUpdate::where('case_id', $id)->latest()->get();
        $fv_updates = FieldVisitUpdate::where('case_id', $id)->latest()->get();
        $ms_updates = MiscellaneousUpdate::where('case_id', $id)->latest()->get();
        return view('admin.cases.show', compact('case', 'gn_updates', 'cr_updates', 'fv_updates', 'ms_updates', 'client_details'));
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
            'gn_updates.*' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'fv_date' => 'required',
            'gn_summary' => 'nullable',
            'cr_updates.*' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'cr_summary' => 'nullable',
            'fv_update.*' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'fv_summary' => 'nullable',
            'ms_update.*' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'ms_summary' => 'nullable',
        ]);

        if ($request->gn_updates) {

            $gn_updates = [];
            if ($request->gn_updates) {
                foreach ($request->gn_updates as $key => $gn_update) {
                    $imageName = time() . rand(1000, 10000) . '.' . $gn_update->extension();
                    $gn_update->move(public_path('documents'), $imageName);

                    //  $gn_updates[]['gn_update'] = $imageName;

                    GeneralCaseUpdate::create([
                        'case_id' => $request->case_id,
                        'fv_date' => $request->fv_date,
                        'cr_summary' => $request->cr_summary,
                        'gn_update' => $imageName,
                    ]);
                }
            }

            record_updated_flash();
        }

        if ($request->cr_updates) {
            $cr_updates = [];
            if ($request->cr_updates) {
                foreach ($request->cr_updates as $key => $cr_update) {
                    $imageName = time() . rand(1000, 10000) . '.' . $cr_update->extension();
                    $cr_update->move(public_path('documents'), $imageName);

                    //  $gn_updates[]['gn_update'] = $imageName;

                    CorrespondenceUpdate::create([
                        'case_id' => $request->case_id,
                        'fv_date' => $request->fv_date,
                        'cr_summary' => $request->cr_summary,
                        'cr_update' => $imageName,
                    ]);
                }
            }

            record_updated_flash();
        }

        if ($request->fv_updates) {
            $fv_updates = [];
            if ($request->fv_updates) {
                foreach ($request->fv_updates as $key => $fv_update) {
                    $imageName = time() . rand(1000, 10000) . '.' . $fv_update->extension();
                    $fv_update->move(public_path('documents'), $imageName);

                    //  $gn_updates[]['gn_update'] = $imageName;

                    FieldVisitUpdate::create([
                        'case_id' => $request->case_id,
                        'fv_date' => $request->fv_date,
                        'fv_summary' => $request->fv_summary,
                        'fv_update' => $imageName,
                    ]);
                }
            }
            $field_visit_number = Cases::where('id', '=', $request->case_id)->first();
            $remaining = $field_visit_number->field_visit - 1;
            $field_visit_number->bal_field_visit = $remaining;
            $field_visit_number->save();

            record_updated_flash();
        }

        if ($request->ms_updates) {
            $ms_updates = [];
            if ($request->ms_updates) {
                foreach ($request->ms_updates as $key => $ms_update) {
                    $imageName = time() . rand(1000, 10000) . '.' . $ms_update->extension();
                    $ms_update->move(public_path('documents'), $imageName);

                    //  $gn_updates[]['gn_update'] = $imageName;

                    MiscellaneousUpdate::create([
                        'case_id' => $request->case_id,
                        'fv_date' => $request->fv_date,
                        'cr_summary' => $request->ms_summary,
                        'ms_update' => $imageName,
                    ]);
                }
            }

            record_updated_flash();
        }
        return back();
    }


    public function updateAdminFee(Request $request, $id)
    {
        $request->validate([
            'admin_fee' => 'nullable',
            'admin_fee_paid' => 'nullable',
            'admin_fee_balance' => 'nullable',
        ]);
        $fee = Client::find($id);
        $fee->update($request->all());
        return redirect()->route('admin.clients.show', $id);
    }



    public function showSingleFieldVisitUpdate(Request $request)
    {
        $fv_case_update = FieldVisitUpdate::find($request->id);
        $response = [
            'status' => 200,
            'message' => 'Data Fetched Successfully',
            'data' =>  $fv_case_update,
        ];
        return response()->json($response);
    }

    public function showGeneralCaseUpdate(Request $request)
    {
        $gn_case_update = GeneralCaseUpdate::find($request->id);
        $response = [
            'status' => 200,
            'message' => 'Data Fetched Successfully',
            'data' =>  $gn_case_update,
        ];
        return response()->json($response);
    }

    public function showCorrespondenceUpdate(Request $request)
    {
        $cr_case_update = CorrespondenceUpdate::find($request->id);
        $response = [
            'status' => 200,
            'message' => 'Data Fetched Successfully',
            'data' =>  $cr_case_update,
        ];
        return response()->json($response);
    }

    public function showMiscellaneousUpdate(Request $request)
    {
        $ms_case_update = MiscellaneousUpdate::find($request->id);
        $response = [
            'status' => 200,
            'message' => 'Data Fetched Successfully',
            'data' =>  $ms_case_update,
        ];
        return response()->json($response);
    }




    public function viewFieldVisitUpdate($id)
    {
        set_page_meta('FV Update');
        $case = Cases::find($id);
        $case_id = $id;
        //$gn_updates = GeneralCaseUpdate::where('case_id', $id)->latest()->get();
        //$cr_updates = CorrespondenceUpdate::where('case_id', $id)->latest()->get();
        $fv_updates = FieldVisitUpdate::where('case_id', $id)->latest()->get();
        //$ms_updates = MiscellaneousUpdate::where('case_id', $id)->latest()->get();
        return view('admin.cases.show-fv-update', compact('fv_updates', 'case'));
    }
    public function viewGeneralCaseUpdate($id)
    {
        set_page_meta('General Case Update');
        $case = Cases::find($id);
        $case_id = $id;
        $gn_updates = GeneralCaseUpdate::where('case_id', $id)->latest()->get();
        //$cr_updates = CorrespondenceUpdate::where('case_id', $id)->latest()->get();
        //$fv_updates = FieldVisitUpdate::where('case_id', $id)->latest()->get();
        //$ms_updates = MiscellaneousUpdate::where('case_id', $id)->latest()->get();
        return view('admin.cases.show-gn-case-update', compact('gn_updates', 'case'));
    }

    public function viewCorrespondenceUpdate($id)
    {
        set_page_meta('CR Update');
        $case = Cases::find($id);
        $case_id = $id;
        //$gn_updates = GeneralCaseUpdate::where('case_id', $id)->latest()->get();
        $cr_updates = CorrespondenceUpdate::where('case_id', $id)->latest()->get();
        //$fv_updates = FieldVisitUpdate::where('case_id', $id)->latest()->get();
        //$ms_updates = MiscellaneousUpdate::where('case_id', $id)->latest()->get();
        return view('admin.cases.show-cr-case-update', compact('cr_updates', 'case'));
    }
    public function viewMiscellaneousUpdate($id)
    {
        set_page_meta('MS Update');
        $case = Cases::find($id);
        $case_id = $id;
        //$gn_updates = GeneralCaseUpdate::where('case_id', $id)->latest()->get();
        //$cr_updates = CorrespondenceUpdate::where('case_id', $id)->latest()->get();
        //$fv_updates = FieldVisitUpdate::where('case_id', $id)->latest()->get();
        $ms_updates = MiscellaneousUpdate::where('case_id', $id)->latest()->get();
        return view('admin.cases.show-ms-case-update', compact('ms_updates', 'case'));
    }

    public function printableCaseAgreement($id)
    {
        return view('admin.agreement.agreement');
    }

    public function updateTotalAmountBalance(Request $request, $id){
        $request->validate([
            'total_amount_balance' => 'nullable',
            // 'admin_fee_paid' => 'nullable',
            // 'amount_unpaid' => 'nullable',
        ]);
        $fee = Cases::find($id);
        $fee->update($request->all());
        return redirect()->route('admin.cases.show', $id);
    }
}
