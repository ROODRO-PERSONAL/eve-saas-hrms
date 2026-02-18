<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;


Route::middleware('auth:sanctum')->group(function(){
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/register',[AuthController::class,'register']);
    Route::get('/me',[AuthController::class,'me']);

    Route::get('/companies',[CompanyController::class,'index']);
    Route::post('/companies',[CompanyController::class,'storeWithUser']);
    Route::get('/companies/{id}',[CompanyController::class,'show']);
    Route::put('/companies/{id}',[CompanyController::class,'update']);
    Route::delete('/companies/{id}',[CompanyController::class,'destroy']);

    Route::get('/users',[UserController::class,'index']);
    Route::post('/users',[UserController::class,'store']);
    Route::get('/users/{id}',[UserController::class,'show']);
    Route::put('/users/{id}',[UserController::class,'update']);
    Route::delete('/users/{id}',[UserController::class,'destroy']);

    Route::get('/employees',[EmployeeController::class,'index']);
    Route::post('/employees',[EmployeeController::class,'store']);
    Route::get('/employees/{id}',[EmployeeController::class,'show']);
    Route::put('/employees/{id}',[EmployeeController::class,'update']);
    Route::delete('/employees/{id}',[EmployeeController::class,'destroy']);

    Route::post('/attendance/clock-in/{employee_id}',[AttendanceController::class,'clockIn']);
    Route::post('/attendance/clock-out/{employee_id}',[AttendanceController::class,'clockOut']);
    Route::get('/attendance',[AttendanceController::class,'index']);

    Route::post('/leaves/apply',[LeaveController::class,'apply']);
    Route::get('/leaves',[LeaveController::class,'index']);
    Route::patch('/leaves/{id}/status',[LeaveController::class,'updateStatus']);
    Route::patch('/leaves/{id}', [LeaveController::class, 'update']);
});
