<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department = Department::first();
        
        $user = User::create([
            'name' => 'InnowaveTech',
            'email' => 'admin@local.com',
            'password' => bcrypt('123456'),
            'phone' => 85712251,
            'department_id' => $department->id,
        ]);
        $role = Role::create(['name' => 'Super Admin']);
        $user->assignRole([$role->id]);


        $user = User::create([
            'name' => 'InnoDev',
            'email' => 'dev@local.com',
            'password' => bcrypt('123456'),
            'phone' => 85712251,
            'department_id' => $department->id,
        ]);
        $permissions = Permission::pluck('id', 'id')->all();
        $role = Role::create(['name' => 'Admin']);
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}