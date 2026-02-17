<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $leaves = Leave::where('company_id', $request->user()->company_id)->get();
        return response()->json($leaves);
    }

    public function apply(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        $data['company_id'] = $request->user()->company_id;

        $leave = Leave::create($data);
        return response()->json($leave, 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $leave = Leave::where('company_id', $request->user()->company_id)->findOrFail($id);

        $data = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $leave->update($data);
        return response()->json($leave);
    }

    public function update(Request $request, $id)
    {
        $leave = Leave::where('company_id', $request->user()->company_id)->findOrFail($id);

        $data = $request->validate([
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'reason' => 'sometimes|string',
            'status' => 'sometimes|in:pending,approved,rejected'
        ]);

        $leave->update($data);

        return response()->json($leave);
    }
}
