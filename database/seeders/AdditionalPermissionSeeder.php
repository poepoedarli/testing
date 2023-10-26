<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdditionalPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'application-list',
            'application-create',
            'application-edit',
            'application-delete',
            'application-control',

            'dataset-list',
            'dataset-create',
            'dataset-edit',
            'dataset-delete',

        ];
     
        $role = Role::find(1);
        foreach ($permissions as $permission) {
            $permission = Permission::create(['name' => $permission]);
            $role->givePermissionTo($permission);
        }
    }
}
