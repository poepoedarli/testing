<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            'department-list',
            'department-create',
            'department-edit',
            'department-delete',

            'dashboard',
            'logs-audit',
            'logs-system',
            
            'service-list',
            'service-create',
            'service-edit',
            'service-delete',

            'order-list',
            'submit-order',
            'user-service-list',
            'confirm-service',
            'payment-order',
            'service-log',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}