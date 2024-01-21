<?php

namespace App\Services;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\BaseService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService extends BaseService
{

    protected $model;

    public function __construct()
    {
        $this->model = Role::class;
    }

    public function storeOrUpdate($data, $id = null)
    {
        try {
            if ($id == null) {
                $role = Role::create(['name' => $data['name']]);
                // sync all permission to the role
                return $role->syncPermissions($data['permission']);
            } else {
                $role = Role::find($id);
                $role->name = $data['name'];
                $role->save();

                return $role->syncPermissions($data['permission']);
            }
        } catch (\Exception $e) {
            $this->logFlashThrow($e);
        }
    }

    public function roleEdit($id)
    {
        $role           = Role::find($id);
        $permissions    = Permission::get();
        $rolePermission = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        $rolePermissions = array_values($rolePermission);

        return $data = [
            'role'            => $role,
            'permissions'     => $permissions,
            'rolePermissions' => $rolePermissions
        ];
    }
}

