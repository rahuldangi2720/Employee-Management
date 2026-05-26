<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [ApiController::class, 'apiDashboard']);
Route::get('/admin/dashboard', [ApiController::class, 'apiRoleDashboard'])->defaults('role', 'admin');
Route::get('/hr/dashboard', [ApiController::class, 'apiRoleDashboard'])->defaults('role', 'hr');
Route::get('/employee/dashboard', [ApiController::class, 'apiRoleDashboard'])->defaults('role', 'employee');

Route::post('/signup', [ApiController::class, 'apiSignup']);
Route::post('/login', [ApiController::class, 'apiLogin']);
Route::post('/admin/login', [ApiController::class, 'apiLogin'])->defaults('role', 'admin');
Route::post('/hr/login', [ApiController::class, 'apiLogin'])->defaults('role', 'hr');
Route::post('/employee/login', [ApiController::class, 'apiLogin'])->defaults('role', 'employee');

Route::get('/employees', [ApiController::class, 'apiEmployees']);
Route::get('/employees/{id}', [ApiController::class, 'apiSingleEmployee']);

Route::get('/departments', [ApiController::class, 'apiDepartments']);
Route::get('/departments/{id}', [ApiController::class, 'apiSingleDepartment']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [ApiController::class, 'apiMe']);
    Route::post('/logout', [ApiController::class, 'apiLogout']);

    Route::post('/employees', [ApiController::class, 'apiStoreEmployee']);
    Route::put('/employees/{id}', [ApiController::class, 'apiUpdateEmployee']);
    Route::patch('/employees/{id}', [ApiController::class, 'apiUpdateEmployee']);
    Route::delete('/employees/{id}', [ApiController::class, 'apiDeleteEmployee']);

    Route::post('/departments', [ApiController::class, 'apiStoreDepartment']);
    Route::put('/departments/{id}', [ApiController::class, 'apiUpdateDepartment']);
    Route::patch('/departments/{id}', [ApiController::class, 'apiUpdateDepartment']);
    Route::delete('/departments/{id}', [ApiController::class, 'apiDeleteDepartment']);
});
