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
               'Dashboard Cards',
               'Dashboard Charts',
               'Dashboard Pie Charts',
           ],
           'User' => [
               'All Users',
               'Create User',
               'Edit User',
               'Delete User',
           ],
           'Debtor' => [
               'All Debtor',
               'Create Debtor',
               'Edit Debtor',
               'Delete Debtor',
           ],
           'Grading' => [
               'All Gradings',
               'Create Grading',
               'Edit Grading',
               'Delete Grading',
           ],
           'Receiving' => [
               'All Receiving',
               'Create Receiving',
               'Edit Receiving',
               'Delete Receiving',
           ],
           'Labels' => [
               'All Labels',
               'Create Labels',
               'Edit Labels',
               'Delete Labels',
           ],
           'Completion' => [
               'All Completion',
               'Create Completion',
               'Edit Completion',
               'Delete Completion',
           ],
           'Shipping' => [
               'All Shipping',
               'Create Shipping',
               'Edit Shipping',
               'Delete Shipping',
           ],
           'View' => [
               'All Views',
               'Create View',
               'Edit View',
               'Delete View',
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
