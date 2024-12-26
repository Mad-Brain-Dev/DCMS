<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\FieldVisitUpdate;
use App\Models\GeneralCaseUpdate;
use App\Models\Installment;
use App\Models\Task;
use App\Models\Task as ModelsTask;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        set_page_meta(content: 'Tasks');
        $admin_installments = ModelsTask::with('installment')
            ->where('assign_type', 'Admin')
            ->where('status', 'not_complete')
            ->get();

        $accounts_installments = ModelsTask::with('installment')
            ->where('assign_type', 'Accounts')
            ->where('status', 'not_complete')
            ->get();

        $completed_tasks = ModelsTask::where('status', 'complete')->get();

        return view("admin.tasks.index", compact("admin_installments", "accounts_installments", "completed_tasks"));
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
        set_page_meta(content: 'Tasks');
        $tasks = ModelsTask::find($id);
        return view("admin.tasks.show", compact("tasks"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        set_page_meta(content: 'Edit Updates');
        $task  = ModelsTask::find($id);
        $installment = Installment::where("id", "=", $task->installment_id)->first();
        $general_case_update = GeneralCaseUpdate::where("installment_id", "=", $installment->id)->first();
        $fv_case_update = FieldVisitUpdate::where("installment_id", "=", $installment->id)->first();

        $employees = User::where('user_type', 'employee')->get();
        return view("admin.tasks.edit", compact("employees", "installment", "task", "general_case_update", "fv_case_update"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the task record
        $task = ModelsTask::findOrFail($id);

        // Validate the request data
        $request->validate([
            'gn_updates.*' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'fv_date' => 'nullable',
            'amount_paid' => 'required',
            'legal_cost' => 'nullable',
            'payment_date' => 'required',
            'collected_by_id' => 'nullable',
            'gn_summary' => 'nullable',
            'payment_method' => 'nullable',
            'assign_type' => 'required',
            'next_payment_date' => 'required',
            'next_payment_amount' => 'required',
            'fv_update.*' => 'nullable|mimes:png,jpg,jpeg,pdf',
            'fv_summary' => 'nullable',
            'remarks' => 'nullable',
        ]);

        // Find the existing installment record
        $installment = Installment::where('id', $task->installment_id)->first();

        if($installment->update_update_type == "general"){
            if ($installment) {
                // Update the installment record with new data
                $installment->update([
                    'amount_paid' => $request->amount_paid,
                    'next_payment_amount' => $request->next_payment_amount,
                    'collected_by_id' => $request->collected_by_id ?? 2, // Default to 2 if null
                    'next_payment_date' => $request->next_payment_date,
                    'payment_method' => $request->payment_method,
                    'assign_type' => $request->assign_type,
                    'fv_date' => $request->fv_date,
                    'date_of_payment' => $request->payment_date,
                ]);
            } else {
                // If installment doesn't exist, you may handle this case separately (e.g., create a new one or show an error).
                return back()->withErrors('Installment not found');
            }

            // Handle the general case updates
            $gn_update = GeneralCaseUpdate::where('installment_id', $installment->id)->first();

            // If file(s) are uploaded
            if ($request->gn_updates) {
                foreach ($request->gn_updates as $gn_update_file) {
                    $imageName = time() . rand(1000, 10000) . '.' . $gn_update_file->extension();
                    $gn_update_file->move(public_path('documents'), $imageName);

                    // Update the GeneralCaseUpdate record with the new file and other details
                    if ($gn_update) {
                        $gn_update->update([
                            'remarks' => $request->remarks,
                            'fv_date' => $request->fv_date,
                            'gn_summary' => $request->gn_summary,
                            'gn_update' => $imageName,
                        ]);
                    } else {
                        // If no existing GeneralCaseUpdate record, create a new one
                        $gn_update = GeneralCaseUpdate::create([
                            'remarks' => $request->remarks,
                            'fv_date' => $request->fv_date,
                            'gn_summary' => $request->gn_summary,
                            'gn_update' => $imageName,
                        ]);
                    }
                }
            } else {
                // If no file is uploaded, just update or create the GeneralCaseUpdate without gn_update file
                if ($gn_update) {
                    $gn_update->update([
                        'remarks' => $request->remarks,
                        'fv_date' => $request->fv_date,
                        'gn_summary' => $request->gn_summary,
                    ]);
                } else {
                    // If no existing GeneralCaseUpdate record, create a new one
                    $gn_update = GeneralCaseUpdate::create([
                        'remarks' => $request->remarks,
                        'fv_date' => $request->fv_date,
                        'gn_summary' => $request->gn_summary,
                    ]);
                }
            }

            // Update the general case update with the installment ID
            if ($gn_update) {
                $gn_update->installment_id = $installment->id;
                $gn_update->save();
            }

        }
        else{
            if ($installment) {
                // Update the installment record with new data
                $installment->update([
                    'amount_paid' => $request->amount_paid,
                    'next_payment_amount' => $request->next_payment_amount,
                    'collected_by_id' => $request->collected_by_id ?? 2, // Default to 2 if null
                    'next_payment_date' => $request->next_payment_date,
                    'payment_method' => $request->payment_method,
                    'assign_type' => $request->assign_type,
                    'fv_date' => $request->fv_date,
                    'date_of_payment' => $request->payment_date,
                ]);
            } else {
                // If installment doesn't exist, you may handle this case separately (e.g., create a new one or show an error).
                return back()->withErrors('Installment not found');
            }

            // Handle the general case updates
            $fv_update = FieldVisitUpdate::where('installment_id', $installment->id)->first();

            // If file(s) are uploaded
            if ($request->fv_updates) {
                foreach ($request->fv_updates as $fv_update_file) {
                    $imageName = time() . rand(1000, 10000) . '.' . $fv_update_file->extension();
                    $fv_update_file->move(public_path('documents'), $imageName);

                    // Update the GeneralCaseUpdate record with the new file and other details
                    if ($fv_update) {
                        $fv_update->update([
                            'remarks' => $request->remarks,
                            'fv_date' => $request->fv_date,
                            'fv_summary' => $request->fv_summary,
                            'fv_update' => $imageName,
                        ]);
                    } else {
                        // If no existing GeneralCaseUpdate record, create a new one
                        $fv_update = FieldVisitUpdate::create([
                            'remarks' => $request->remarks,
                            'fv_date' => $request->fv_date,
                            'fv_summary' => $request->fv_summary,
                            'fv_update' => $imageName,
                        ]);
                    }
                }
            } else {
                // If no file is uploaded, just update or create the GeneralCaseUpdate without gn_update file
                if ($fv_update) {
                    $fv_update->update([
                        'remarks' => $request->remarks,
                        'fv_date' => $request->fv_date,
                        'gn_summary' => $request->fv_summary,
                    ]);
                } else {
                    // If no existing GeneralCaseUpdate record, create a new one
                    $fv_update = GeneralCaseUpdate::create([
                        'remarks' => $request->remarks,
                        'fv_date' => $request->fv_date,
                        'fv_summary' => $request->fv_summary,
                    ]);
                }
            }

            // Update the general case update with the installment ID
            if ($fv_update) {
                $fv_update->installment_id = $installment->id;
                $fv_update->save();
            }
        }


        // Trigger any flash or session updates
        record_updated_flash();

        return back()->with('success', 'Update successful');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Task::find($id);

        // Check if the item exists
        if (!$item) {
            return back()->with('error', 'Item not found!');
        } else {

            $installment = Installment::find($item->installment_id);
            $gn_update = GeneralCaseUpdate::where('installment_id', $installment->id);
            $fv_update = FieldVisitUpdate::where('installment_id', $installment->id);
            $installment->delete();
            $gn_update->delete();
            $fv_update->delete();
            $item->delete();
            //update task status
            $item->status = 'complete';
            $item->save();
        }

        //        $ammount_paid = $installment->amount_paid;
        //        $case_id = $installment->case_id;
        //
        //        $case = Cases::find($case_id);
        //
        //        return $case;

        //        $case->total_amount = $case->total_amount + $ammount_paid;

        // Flash success message
        record_deleted_flash();
        return redirect()->route('admin.tasks.index');
    }

    public function markAsComplete($id)
    {
        $task_item = ModelsTask::find($id);
        $task_item->status = 'complete';
        $task_item->save();
        // $installment_item = Installment::where('id', $task_item->installment_id)->first();
        // $installment_item->status = 'complete';
        // $installment_item->save();

        return redirect()->route('admin.tasks.index');
    }
}
