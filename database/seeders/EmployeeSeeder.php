<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Company;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $companies = Company::all();
        foreach ($companies as $company) {
            for ($i = 1; $i <= 5; $i++) {
                Employee::create([
                    'name' => $company->name . " Employee $i",
                    'email' => strtolower(str_replace(' ', '', $company->name)) . "employee$i@example.com",
                    'position' => 'Staff',
                    'company_id' => $company->id
                ]);
            }
        }
    }
}
