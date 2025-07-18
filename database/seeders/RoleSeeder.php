<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            // [
            //     'name' => 'Admin',
            // ],
            [
                'name' => 'Employee',
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);

        }
    }
}
