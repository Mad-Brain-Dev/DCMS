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
}
