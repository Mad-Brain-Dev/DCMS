<?php

namespace App\Http\Controllers\Admin\User;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserRequest;
use App\Models\Cases;
use App\Models\User;
use App\Services\UserEditService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{

    protected $userService, $userEditService;

    public function __construct(UserService $userService, UserEditService $userEditService)
    {
        $this->userService = $userService;
        $this->userEditService = $userEditService;
    }

    public function index(UserDataTable $dataTable)
    {
        set_page_meta('Admins');
        return $dataTable->render('admin.users.index');
    }

    public function create()
    {
        set_page_meta('Create User');
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        try {
            $user = $this->userService->storeOrUpdate($data, null);
            $user->name = $user->first_name.' '.$user->last_name;
            $user->save();
            $user->assignRole([$request->input('role')]);
            record_created_flash();
        } catch (\Exception $e) {
        }
        return redirect()->route('admin.users.index');
    }

    public function edit($id)
    {

        try {
            set_page_meta('Edit User');
            $user = $this->userService->get($id);
            $userRole = $user->roles->pluck('name')->toArray();
            $roles = Role::latest()->get();
            return view('admin.users.edit', compact('user','roles','userRole'));
        } catch (\Exception $e) {
            log_error($e);
        }
        return back();
    }

    public function update(UserEditRequest $request, $id)
    {
         $data = $request->validated();
         $user = $this->userEditService->storeOrUpdate($data, $id);
         $user = User::find($id);
         $user->syncRoles([$request->input('role')]);
        try {

          record_updated_flash();
        } catch (\Exception $e) {
            return back();
        }
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->userService->delete($id);
            record_deleted_flash();
            return back();
        } catch (\Exception $e) {
            return back();
        }
    }
}
