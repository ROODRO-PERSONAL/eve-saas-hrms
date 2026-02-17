<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Attendance::where('company_id', $request->user()->company_id)->get();
        return response()->json($attendances);
    }

    public function clockIn(Request $request, $employee_id)
    {
        $employee = Employee::where('company_id', $request->user()->company_id)
                            ->findOrFail($employee_id);

        $attendance = Attendance::create([
            'employee_id' => $employee->id,
            'company_id' => $request->user()->company_id,
            'clock_in' => now(),
        ]);

        return response()->json($attendance);
    }

    public function clockOut(Request $request, $employee_id)
    {
        $employee = Employee::where('company_id', $request->user()->company_id)
                            ->findOrFail($employee_id);

        $attendance = Attendance::where('employee_id', $employee->id)
                                ->whereNull('clock_out')
                                ->latest()
                                ->first();

        if (!$attendance) {
            return response()->json(['message' => 'Clock-in not found'], 404);
        }

        $attendance->update(['clock_out' => now()]);
        return response()->json($attendance);
    }
}
