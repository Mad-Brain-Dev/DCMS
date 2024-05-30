<?php

namespace App\Http\Controllers\Admin\Employee;

use App\DataTables\EmployeeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeEditRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\User;
use App\Services\EmployeeEditService;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeService, $employeeEditService;

    public function __construct(EmployeeService $employeeService, EmployeeEditService $employeeEditService)
    {
        $this->employeeService = $employeeService;
        $this->employeeEditService = $employeeEditService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(EmployeeDataTable $dataTable)
    {
        set_page_meta('Employees');
        return $dataTable->render('admin.employees.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        set_page_meta('Create Employee');
        // $roles = Role::all();
        return view('admin.employees.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $data = $request->validated();

        try {
            $employee = $this->employeeService->storeOrUpdate($data, null);
            // $user->assignRole([$request->input('role')]);
            if($employee){
                $employee->user_type = User::USER_TYPE_EMPLOYEE;
                $employee->name = $employee->first_name.' '.$employee->last_name;
                $employee->save();
            }
            record_created_flash();
        } catch (\Exception $e) {
        }
        return redirect()->route('admin.employees.index');
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

        try {
            set_page_meta('Edit Employee');
            $employee = $this->employeeService->get($id);
           // $userRole = $user->roles->pluck('name')->toArray();
           // $roles = Role::latest()->get();
            return view('admin.employees.edit', compact('employee'));
        } catch (\Exception $e) {
            log_error($e);
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeEditRequest $request, string $id)
    {
        $data = $request->validated();
        try {
          $employee = $this->employeeEditService->storeOrUpdate($data, $id);
        //  $user->syncRoles([$request->input('role')]);
          record_updated_flash();
        } catch (\Exception $e) {
            return back();
        }
        return redirect()->route('admin.employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->employeeService->delete($id);
            record_deleted_flash();
            return back();
        } catch (\Exception $e) {
            return back();
        }
    }
}
