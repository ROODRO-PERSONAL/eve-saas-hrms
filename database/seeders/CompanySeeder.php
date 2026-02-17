<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run()
    {
        $companies = [
            ['name' => 'Acme Corp'],
            ['name' => 'Globex Inc'],
            ['name' => 'Initech'],
        ];

        foreach ($companies as $companyData) {
            $company = Company::create($companyData);

            $user = User::create([
                'name' => $company->name . ' Admin',
                'email' => strtolower(str_replace(' ', '', $company->name)) . '@example.com',
                'password' => Hash::make('password123'),
                'company_id' => $company->id
            ]);

            $token = $user->createToken('api-token')->plainTextToken;
            $user->api_token = $token;
            $user->save();

            DB::table('api_tokens')->insert([
                'user_id' => $user->id,
                'token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("Company: {$company->name}, Admin Email: {$user->email}, Token saved in database.");
        }
    }
}
