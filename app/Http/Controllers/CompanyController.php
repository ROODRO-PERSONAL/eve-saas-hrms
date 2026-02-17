<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function storeWithUser(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'required|string|unique:companies,name',
            'user_name' => 'required|string',
            'user_email' => 'required|email|unique:users,email',
            'user_password' => 'required|string|min:6'
        ]);

        $company = Company::create(['name' => $data['company_name']]);

        $user = User::create([
            'name' => $data['user_name'],
            'email' => $data['user_email'],
            'password' => Hash::make($data['user_password']),
            'company_id' => $company->id
        ]);

        $token = $user->createToken('api-token')->plainTextToken;
        $user->api_token = $token;
        $user->save();

        return response()->json(['company' => $company, 'user' => $user, 'token' => $token], 201);
    }

    public function index()
    {
        return response()->json(Company::all());
    }
    public function show($id)
    {
        return response()->json(Company::findOrFail($id));
    }
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $data = $request->validate(['name' => 'required|string|unique:companies,name,' . $company->id]);
        $company->update($data);
        return response()->json($company);
    }
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(['message' => 'Company deleted']);
    }
}
