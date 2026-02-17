<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::where('company_id', $request->user()->company_id)->get();
        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'position' => 'required|string',
        ]);

        $data['company_id'] = $request->user()->company_id;

        $employee = Employee::create($data);
        return response()->json($employee, 201);
    }

    public function show(Request $request, $id)
    {
        $employee = Employee::where('company_id', $request->user()->company_id)->findOrFail($id);
        return response()->json($employee);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::where('company_id', $request->user()->company_id)->findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:employees,email,' . $employee->id,
            'position' => 'sometimes|required|string',
        ]);

        $employee->update($data);
        return response()->json($employee);
    }

    public function destroy(Request $request, $id)
    {
        $employee = Employee::where('company_id', $request->user()->company_id)->findOrFail($id);
        $employee->delete();

        return response()->json(['message' => 'Employee deleted']);
    }
}
