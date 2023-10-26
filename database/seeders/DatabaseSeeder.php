<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountriesTableSeeder::class,
            PermissionTableSeeder::class,
            DepartmentTableSeeder::class,
            CreateAdminUserSeeder::class,
            AdditionalPermissionSeeder::class,
            ServicesTableSeeder::class
        ]);
    }
}
