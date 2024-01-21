<?php

namespace Database\Seeders;

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
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'Manager',
            ],
            [
                'name' => 'Asst. Manager',
            ],
            [
                'name' => 'Accountant',
            ],
            [
                'name' => 'Editor',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
