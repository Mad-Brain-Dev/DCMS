<?php

namespace App\Http\Controllers\Admin\Employee;

use App\DataTables\EmployeeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeEditRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use App\Services\EmployeeEditService;
use App\Services\EmployeeService;
use App\Utils\GlobalConstant;
use Illuminate\Http\Request;
use App\Models\EmployeeCommission;
use App\Models\EmployeePayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $roles = Role::whereIn('name', ['Manager IC', 'Collector IC', 'Employee'])->get();
        return view('admin.employees.create',compact('roles'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $data = $request->validated();
        $userData = [
            'first_name'=>$data['first_name'],
            'last_name'=>$data['last_name'],
            'email'=>$data['email'],
            'phone'=>$data['phone'],
            'password'=>$data['password'],
            'status'=>GlobalConstant::STATUS_ACTIVE,
        ];

        try {
            $user = $this->employeeService->storeOrUpdate($userData, null);
            // $user->assignRole([$request->input('role')]);
            if($user){
                $user->user_type = User::USER_TYPE_EMPLOYEE;
                $user->name = $user->first_name.' '.$user->last_name;
                $user->save();

                $employee = Employee::create([
                    'user_id'=>$user->id,
                    'first_name'=>$user->first_name,
                    'last_name'=>$user->last_name,
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'phone'=>$user->phone,
                    'role'=>$data['role'],
                    'commission_rate'=>$data['commission_rate'],
                ]);
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
            $roles = Role::whereIn('name', ['Manager IC', 'Collector IC', 'Employee'])->get();
            return view('admin.employees.edit', compact('employee','roles'));
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
            $edited_employee = User::find($id);
            $edited_employee->name =  $edited_employee->first_name .' '. $edited_employee->last_name;
            $edited_employee->save();

            $e = Employee::where('user_id',$id)->first();
            $e->first_name = $edited_employee->first_name;
            $e->last_name = $edited_employee->last_name;
            $e->name = $edited_employee->name;
            $e->email = $edited_employee->email;
            $e->phone = $edited_employee->phone;
            $e->role = $request->role;
            $e->commission_rate = $request->commission_rate;
            $e->save();


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
        $this->employeeService->delete($id);
        try {

            record_deleted_flash();
            return back();
        } catch (\Exception $e) {
            return back();
        }
    }

}
