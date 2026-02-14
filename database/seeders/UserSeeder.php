<?php

namespace Database\Seeders;

// use App\Models\Role;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Utils\GlobalConstant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name'        => 'Mad',
                'last_name'         => 'Brain',
                'name'         => 'Mad Brain',
                'email'             => 'info@madbrain.dev',
                'email_verified_at' => now(),
                'password'          => Hash::make("12345678"),   // 12345678
                'user_type'         => User::USER_TYPE_ADMIN,
                'status'            => GlobalConstant::STATUS_ACTIVE,
                'remember_token'    => Str::random(60),
                'phone'             => '012345678910',
            ],
            [
                'first_name'        => 'Supper',
                'last_name'         => 'Admin',
                'name'         => 'Admin',
                'email'             => 'admin@app.com',
                'email_verified_at' => now(),
                'password'          => Hash::make("12345678"),   // 12345678
                'user_type'         => User::USER_TYPE_ADMIN,
                'status'            => GlobalConstant::STATUS_ACTIVE,
                'remember_token'    => Str::random(60),
                'phone'             => '012345678910',
            ],
            [
                'first_name'        => 'Employee',
                'last_name'         => 'One',
                'Name'         => 'Employee One',
                'email'             => 'employee@app.com',
                'email_verified_at' => now(),
                'password'          => Hash::make("12345678"),   // 12345678
                'user_type'         => User::USER_TYPE_EMPLOYEE,
                'status'            => GlobalConstant::STATUS_ACTIVE,
                'remember_token'    => Str::random(60),
                'phone'             => '012345678910',
            ],
            [
                'first_name'        => 'Client',
                'last_name'         => 'Last',
                'Name'              => 'Client Lat',
                'email'             => 'client@app.com',
                'email_verified_at' => now(),
                'password'          => Hash::make("12345678"),   // 12345678
                'user_type'         => User::USER_TYPE_CLIENT,
                'status'            => GlobalConstant::STATUS_ACTIVE,
                'remember_token'    => Str::random(60),
                'phone'             => '012345678910',
            ],
        ];


        // foreach ($users as $user) {
        //     $user =  User::create($user);
        //     if ($user->user_type == User::USER_TYPE_ADMIN) {
        //         $user->assignRole(['Admin']);
        //     }
        // }

        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        foreach ($users as $user) {
            $user = User::create($user);
            // $user->assignRole([$role->id]);
            if ($user->user_type == User::USER_TYPE_ADMIN) {
                $user->assignRole(['Admin']);
            }
        }
        $employees = [
            [
                'user_id'        => 3,
                'first_name'        => 'Employee',
                'last_name'         => 'One',
                'Name'         => 'Employee One',
                'email'             => 'employee@app.com',
                'status'            => GlobalConstant::STATUS_ACTIVE,
                'phone'             => '012345678910',
                'role' =>'Employee',
                'commission_rate'=>5,
            ],
        ];
        foreach ($employees as $employee){
            Employee::create($employee);
        }

    }
}
