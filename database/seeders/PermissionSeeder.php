<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'Dashboard' => [
                'Show Dashborad',
                'Card Total Cases',
                'Card Total Admin Fee',
                'Card Total Amount Owed',
                'Card Amount Paid',
                'Card Bal Amount',
                'Button Create Client',
                'Button Create Case',
                'Case Status'
            ],
            'Administration' => [
                'Users',
                'Button User Create',
                'Button User Edit',
                'Button User Delete',
                'Employees',
                'Button Employee Create',
                'Button Employee Edit',
                'Button Employee Delete',
                'Roles',
                'Button Role Create',
                'Button Role Edit',
                'Button Role Delete'
            ],
            'Clients' => [
                'Clients',
                'Create Client',
                'Edit Clinet',
                'Delete Clinet'
            ],
            'Cases' => [
                'Cases',
                'Create Case',
                'Edit Case',
                'Delete Case',
            ],
            'Reports' => [
                'Show Report',
            ],
        ];

        foreach ($permissions as $parent => $childs) {
            $id = Permission::create(['name' => $parent])->id;
            foreach ($childs as $child) {
                Permission::create([
                    'parent_id' => $id,
                    'name'      => $child
                ]);
            }
        }
    }
}
