<?php

namespace App\Http\Controllers;

use App\Models\Task as ModelsTask;
use Illuminate\Http\Request;

class Task extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      set_page_meta(content: 'Tasks');
      $admin_installments = ModelsTask::with('installment')
                            ->where('assign_type','Admin' )
                            ->get();

      $accounts_installments = ModelsTask::with('installment')
                            ->where('assign_type','Accounts' )
                            ->get();
      return view("admin.tasks.index", compact("admin_installments", "accounts_installments"));
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
    $item = ModelsTask::find($id);

    // Check if the item exists
    if (!$item) {
        return back()->with('error', 'Item not found!');
    }

    // Delete the item if found
    $item->delete();

    // Flash success message
    record_deleted_flash();


    return redirect()->route('admin.tasks.index');
}

}
