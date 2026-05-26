<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::view('/userlogin', 'userlogin')->name('login');
Route::post('/userlogin', [UserController::class, 'login'])->name('login.submit');

Route::match(['get', 'post'], '/logout', [UserController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');

    Route::redirect('/admin/dashboard', '/dashboard');
    Route::redirect('/hr/dashboard', '/dashboard');
    Route::redirect('/employee/dashboard', '/dashboard');

    Route::get('/adddepartment', function () {
        return view('adddepartment');
    })->middleware('admin')->name('departments.create');

    Route::post('/adddepartment', [DepartmentController::class, 'addDepartment'])
        ->middleware('admin')
        ->name('departments.store');

    Route::get('/employee/create', [EmployeeController::class, 'create'])
        ->middleware('admin')
        ->name('employees.create');

    Route::post('/employee/store', [EmployeeController::class, 'store'])
        ->middleware('admin')
        ->name('employees.store');

    Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])
        ->middleware('admin')
        ->name('employees.edit');

    Route::post('/employee/update/{id}', [EmployeeController::class, 'update'])
        ->middleware('admin')
        ->name('employees.update');

    Route::delete('/employee/delete/{id}', [EmployeeController::class, 'delete'])
        ->middleware('admin')
        ->name('employees.delete');
});
