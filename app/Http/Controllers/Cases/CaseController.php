<?php

namespace App\Http\Controllers\Cases;

use App\DataTables\CaseDataTable;
use App\DataTables\CaseDataTableByStatus;
use App\DataTables\CasesforPerticularClientDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CaseEditRequest;
use App\Http\Requests\CaseRequest;
use App\Models\Cases;
use App\Models\Client;
use App\Models\CorrespondenceUpdate;
use App\Models\FieldVisitUpdate;
use App\Models\GeneralCaseUpdate;
use App\Models\Installment;
use App\Models\MiscellaneousUpdate;
use App\Models\Task;
use App\Models\User;
use App\Services\CaseService;
use App\Services\Utils\FileUploadService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), ['name' => 'required', 'client_id' => 'required']);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()

            ]);
        }
        $case_number = $request->case_number;
        $data = [
            "case_number" => $case_number,
            "case_sku" => $this->caseSkuId($case_number),
            "client_id" => $request->client_id,
            "date_of_warrant" => $request->date_of_warrant,
            "manager_ic" => $request->manager_ic,
            "collector_ic" => $request->collector_ic,
            "current_status" => $request->current_status,
            "case_summary" => $request->case_summary,
            "collection_commission" => $request->collection_commission,
            "field_visit" => $request->field_visit,
            "bal_field_visit" => $request->bal_field_visit,
            "name" => $request->name,
            "nric" => $request->nric,
            "company_name" => $request->company_name,
            "company_uen" => $request->company_uen,
            "email" => $request->email,
            "phone" => $request->phone,
            "adderss" => $request->adderss,
            "guarantor_name" => $request->guarantor_name,
            "guarantor_address" => $request->guarantor_address,
            "remarks_one" => $request->remarks_one,
            "guarantor_name2" => $request->guarantor_name2,
            "guarantor_address2" => $request->guarantor_address2,
            "remarks_two" => $request->remarks_two,
            "guarantor_name3" => $request->guarantor_name3,
            "guarantor_address3" => $request->guarantor_address3,
            "remarks_three" => $request->remarks_three,
            "debt_amount" => $request->debt_amount,
            "legal_cost" => $request->legal_cost,
            "total_interest" => $request->total_interest,
            "total_amount_owed" => $request->total_amount_owed,
            "debt_interest" => $request->debt_interest,
            "interest_type" => $request->principal_interest,
            "interest_start_date" => $request->interest_start_date,
            "interest_end_date" => $request->interest_end_date,
            // "total_amount_balance" => $request->total_amount_balance,
            "remarks" => $request->remarks,
        ];

        $result = Cases::create($data);
        $data = [
            'status' => 200,
            'success' => 'Data Fetched Successfully',
            'result' =>  $result,
        ];
        return response()->json($data);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        set_page_meta('Details');
        $case = Cases::find($id);
        $employees = User::where('user_type', 'employee')->get();
        $client_details = Client::where('id', $case->client_id)->first();
        $gn_updates = GeneralCaseUpdate::where('case_id', $id)->latest()->get();
        $fv_updates = FieldVisitUpdate::where('case_id', $id)->latest()->get();
        $installment = Installment::where('case_id', $id)->latest()->first();
        $installmentByEmployees = Installment::where('case_id', $id)->select('collected_by_id', \DB::raw('SUM(amount_paid) as total_amounts'))
            ->groupBy('collected_by_id')
            ->orderBy('total_amounts', 'desc')
            ->get();
        return view('admin.cases.show', compact('case', 'gn_updates', 'fv_updates', 'client_details', 'installment', 'installmentByEmployees', 'employees'));
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
        $dateofAgreement = Client::where('id', $request->client_id)->first();
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
            'fv_date' => 'nullable',
            'amount_paid' => 'required',
            'legal_cost' => 'nullable',
            'payment_date' => 'required',
            'collected_by_id' => 'nullable',
            'gn_summary' => 'nullable',
            'update_type' => 'nullable',
            'payment_method' => 'nullable',
            'assign_type'=> 'required',
            'next_payment_date' => 'required',
            'next_payment_amount' => 'required',
            'fv_update.*' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'fv_summary' => 'nullable',
            'remarks' => 'nullable',
        ]);
        $paid_amount = Cases::findOrFail($request->case_id);

        $installment = Installment::create([
            'case_id' => $request->case_id,
            'amount_paid' => $request->amount_paid,
            'next_payment_amount' => $request->next_payment_amount,
            'collected_by_id' => $request->collected_by_id == null ? 2 : $request->collected_by_id,
            'next_payment_date' => $request->next_payment_date,
            'payment_method' => $request->payment_method,
            'update_type' => $request->update_type,
            'assign_type' => $request->assign_type,
            'fv_date' => $request->fv_date,
            'date_of_payment' => $request->payment_date,
        ]);
        Task::create([
            'installment_id' => $installment->id,
            'assign_type'=> $request->assign_type,
        ]);
        if ($installment) {
            //     //$installment->collected_by_id = $request->collected_by_id;
            //     // $installment->save_by_user_type = auth()->user()->user_type;
            //     //$installment->save();
            $paid_amount->legal_cost_received = $paid_amount->legal_cost_received + $request->legal_cost;
            $paid_amount->total_amount_balance = $paid_amount->total_amount_balance - $request->amount_paid;
            $paid_amount->save();
        }

        $gn_updates = [];


        if ($request->gn_updates) {


            foreach ($request->gn_updates as $key => $gn_update) {
                $imageName = time() . rand(1000, 10000) . '.' . $gn_update->extension();
                $gn_update->move(public_path('documents'), $imageName);

                //  $gn_updates[]['gn_update'] = $imageName;

                $gn_update =   GeneralCaseUpdate::create([
                    'case_id' => $request->case_id,
                    'remarks' => $request->remarks,
                    'fv_date' => $request->fv_date,
                    'gn_summary' => $request->gn_summary,
                    'gn_update' => $imageName,
                ]);
            }
        } else {
            $gn_update =   GeneralCaseUpdate::create([
                'case_id' => $request->case_id,
                'remarks' => $request->remarks,
                'fv_date' => $request->fv_date,
                'gn_summary' => $request->gn_summary,
                // 'gn_update' => null,

            ]);
        }
        $gn_update->installment_id = $installment->id;
        $gn_update->save();
        record_updated_flash();
        return back();
    }

    public function fieldVisitCaseCreate(Request $request)
    {
        $request->validate([
            'fv_updates.*' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'fv_date' => 'nullable',
            'amount_paid' => 'required',
            'legal_cost' => 'nullable',
            'payment_date' => 'required',
            'next_payment_date' => 'required',
            'next_payment_amount' => 'required',
            'collected_by_id' => 'nullable',
            'payment_method' => 'nullable',
            'update_type' => 'nullable',
            'assign_type'=> 'required',
            'fv_update.*' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'fv_summary' => 'nullable',
            'remarks' => 'nullable',
        ]);
        $paid_amount = Cases::findOrFail($request->case_id);
        $installment = Installment::create([
            'case_id' => $request->case_id,
            'amount_paid' => $request->amount_paid,
            'next_payment_amount' => $request->next_payment_amount,
            'collected_by_id' => $request->collected_by_id == null ? 2 : $request->collected_by_id,
            'next_payment_date' => $request->next_payment_date,
            'update_type' => $request->update_type,
            'payment_method' => $request->payment_method,
            'assign_type'=> $request->assign_type,
            'fv_date' => $request->fv_date,
            'date_of_payment' => $request->payment_date,

        ]);
        Task::create([
            'installment_id' => $installment->id,
            'assign_type'=> $request->assign_type,
        ]);
        if ($installment) {
            //$installment->collected_by_id = $request->collected_by_id;
            // $installment->save_by_user_type = auth()->user()->user_type;
            //$installment->save();
            $paid_amount->legal_cost_received = $paid_amount->legal_cost_received + $request->legal_cost;
            $paid_amount->total_amount_balance = $paid_amount->total_amount_balance - $request->amount_paid;
            $paid_amount->save();
        }

        $field_visit_number = Cases::where('id', '=', $request->case_id)->first();
        // $remaining = $field_visit_number->bal_field_visit - 1;
        $field_visit_number->bal_field_visit == $field_visit_number->bal_field_visit--;
        $field_visit_number->save();





        $fv_updates = [];


        if ($request->fv_updates) {
            foreach ($request->fv_updates as $key => $fv_update) {
                $imageName = time() . rand(1000, 10000) . '.' . $fv_update->extension();
                $fv_update->move(public_path('documents'), $imageName);

                //  $gn_updates[]['gn_update'] = $imageName;

                $fv_update =   FieldVisitUpdate::create([
                    'case_id' => $request->case_id,
                    'installment_id' => $installment->id,
                    'remarks' => $request->remarks,
                    'fv_summary' => $request->fv_summary,
                    'fv_date' => $request->fv_date,
                    'fv_update' => $imageName,
                ]);
            }
        } else {
            $fv_update =   FieldVisitUpdate::create([
                'case_id' => $request->case_id,
                'installment_id' => $installment->id,
                'remarks' => $request->remarks,
                'fv_date' => $request->fv_date,
                'fv_summary' => $request->gn_summary,
                // 'gn_update' => null,

            ]);
        }
        $fv_update->installment_id = $installment->id;
        $fv_update->save();
        record_updated_flash();
        return back();
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

        $case_number = Cases::find($id);
        $client_details = Client::where('id', $case_number->client_id)->first();
        return view('admin.agreement.agreement', compact('case_number', 'client_details'));
    }

    public function printableLetter($id)
    {
        $case_number = Cases::find($id);
        $client_details = Client::where('id', $case_number->client_id)->first();
        return view('admin.agreement.letter', compact('case_number', 'client_details'));
    }

    public function updateTotalAmountBalance(Request $request, $id)
    {
        $request->validate([
            'total_amount_balance' => 'nullable',
            'total_amount_paid' => 'nullable',
            // 'amount_unpaid' => 'nullable',
        ]);
        $fee = Cases::find($id);
        $fee->update($request->all());
        return redirect()->route('admin.cases.show', $id);
    }

    public function clientSearch()
    {
        $clients = Client::select('name')->get();
        $data = [];
        foreach ($clients as $client) {
            $data[] = $client['name'];
        }
        return $data;
    }

    public function caseSearch()
    {
        $cases = Cases::select('case_sku')->get();
        $data = [];
        foreach ($cases as $case) {
            $data[] = $case['case_sku'];
        }
        return $data;
    }


    public function searchForClient(Request $request)
    {
        $searched_client = $request->client_search;
        if ($searched_client != "") {
            $client = Client::where("name", "LIKE", "%$searched_client%")->first();
            if ($client) {
                return redirect('admin/clients/' . $client->id);
            }
            // if ($case) {
            //     return redirect('admin/cases/'.$case->id);
            // }
            else {
                session()->flash('status', 'No client matched your search');
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function searchForCase(Request $request)
    {
        $searched_case = $request->case_search;
        if ($searched_case != "") {
           // $case = Cases::where("case_sku", "LIKE", "%$searched_case%")->first();
           $case = Cases::where("case_sku", "LIKE", "%$searched_case%")
            ->orWhere("name", "LIKE", "%$searched_case%")
            ->orWhere("company_name", "LIKE", "%$searched_case%")
            ->orWhere("phone", "LIKE", "%$searched_case%")
            ->orWhere("adderss", "LIKE", "%$searched_case%")
            ->first();
            if ($case) {
                return redirect('admin/cases/' . $case->id);
            }
            // if ($case) {
            //     return redirect('admin/cases/'.$case->id);
            // }
            else {
                session()->flash('status', 'No client matched your search');
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }


    //get case by status

    public function getCasebyStatus(CaseDataTableByStatus $dataTable, $status)
    {
        set_page_meta('Cases by Status');
        $query_status = $status == "" ? null : $status;
        return $dataTable->with('status', $query_status)->render('admin.cases.index');
    }

    //case id create
    public function caseSkuId($case_number)
    {
        $cases = Cases::all();
        if ($cases->count() > 0) {

            $lastSKUId = Cases::orderBy('id', 'DESC')->first()->case_sku;
            $splitedLastSKUId = str_split($lastSKUId, 12);
            // $madedSKU = $splitedLastSKUId[1] . $splitedLastSKUId[2];
            $madedSKU  = $splitedLastSKUId[1];
            $madedSKU = (int)$madedSKU;
            $settingPlusOne = $madedSKU + 1;
            // dd($settingPlusOne);
            $newSKUId = $case_number . ' ' . $settingPlusOne;
            return $newSKUId;
        } else {
            //            $setting = config('settings.admin_order_sku');
            $setting = 10000;
            $settingPlusOne = $setting + 1;
            $newSKUId = $case_number . ' ' . $settingPlusOne;
            return $newSKUId;
        }
    }

    public function debtorDetails($id){
       $debtor_details = Cases::where('id', $id)->first();
       $installments_details = Installment::where('case_id', $id)->get();
       return view('admin.debtor.debtor-details',compact('debtor_details','installments_details'));
    }
}
