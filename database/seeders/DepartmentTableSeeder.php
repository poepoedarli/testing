<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    public function run()
    {
        Department::create([
            'name' => 'Innowave Tech',
            'desc' => 'Innowave Tech',
            'status' => 1,
        ]);
    }
}
