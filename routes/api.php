<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// ==========================================
// DASHBOARD API
// ==========================================

Route::get('/dashboard',
[ApiController::class,'apiDashboard']);



// ==========================================
// GET ALL EMPLOYEES API
// ==========================================

Route::get('/employees',
[ApiController::class,'apiEmployees']);



// ==========================================
// GET SINGLE EMPLOYEE API
// ==========================================

Route::get('/employees/{id}',
[ApiController::class,'apiSingleEmployee']);



// ==========================================
// STORE EMPLOYEE API
// ==========================================

Route::post('/employees',
[ApiController::class,'apiStoreEmployee']);



// ==========================================
// UPDATE EMPLOYEE API
// ==========================================

Route::put('/employees/{id}',
[ApiController::class,'apiUpdateEmployee']);



// ==========================================
// DELETE EMPLOYEE API
// ==========================================

Route::delete('/employees/{id}',
[ApiController::class,'apiDeleteEmployee']);


// ==========================================
// USER AUTH APIs
// ==========================================

Route::post('/signup',
[ApiController::class,'apiSignup']);

Route::post('/login',
[ApiController::class,'apiLogin']);

Route::post('/logout',
[ApiController::class,'apiLogout']);


// ==========================================
// DEPARTMENT APIs
// ==========================================

Route::get('/departments',
[ApiController::class,'apiDepartments']);

Route::get('/departments/{id}',
[ApiController::class,'apiSingleDepartment']);

Route::post('/departments',
[ApiController::class,'apiStoreDepartment']);

Route::put('/departments/{id}',
[ApiController::class,'apiUpdateDepartment']);

Route::delete('/departments/{id}',
[ApiController::class,'apiDeleteDepartment']);