<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $companyId = $request->user()->company_id;
        $users = User::where('company_id', $companyId)->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['company_id'] = $request->user()->company_id;

        $user = User::create($data);
        return response()->json($user, 201);
    }

    public function show(Request $request, $id)
    {
        $companyId = $request->user()->company_id;
        $user = User::where('company_id', $companyId)->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $companyId = $request->user()->company_id;
        $user = User::where('company_id', $companyId)->findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:6',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return response()->json($user);
    }

    public function destroy(Request $request, $id)
    {
        $companyId = $request->user()->company_id;
        $user = User::where('company_id', $companyId)->findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
