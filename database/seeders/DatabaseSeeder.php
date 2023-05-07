<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 companies using the CompanyFactory
        \App\Models\Company::factory(10)->create();

        // Create 10 companies using the EmployeeFactory
        \App\Models\Employee::factory(10)->create();

        // Creating users using the UserSeeder
        $this->call([
            UserSeeder::class,
        ]);
    }
}
