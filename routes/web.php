<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('/userform ');
});



 // Route::redirect('/','/home');  redirect directing in routing





// Route::get( '/about' , function () { 
//     return view('aboutus');
// });  first method of routing   // when controler is also open then we use method

Route::get('/home',[UserController::class,'home'])->middleware('auth');   // second method of routing   // for view open


Route::get( '/about' ,function (){
    return view('about');
});


Route::get( '/about/{name}' ,function ($name){
 
 //echo $name;
return view('about', ['name' => $name]);
});     // FOR SENDING DYNAMIC DATA IN URL USING ROUTING


Route::get('user',[UserController::class , 'getUser']);  // call controller  ,  call view from controller  and route




Route::get('user/{name}/{age} ',[UserController::class , 'getUserName']);  // pass data ffrom route to controller 
Route::get('user',[UserController::class , 'user']);  // call view with controller




Route::get('admin/login',[UserController::class , 'admin']);    // nested view call through controlller  
Route::get('admin/signup',[UserController::class , 'main']);  





// for user signup
Route::view('/userform' , 'usersingup-form');
Route::post('/adduser' , [UserController::class,'submit']);

// for user login
Route::view('/userlogin','userlogin');
Route::post('/userlogin',[UserController::class,'login']);

Route::get('/logout', [UserController::class , 'logout']);



/// for department 

Route::view('/adddepartment','adddepartment');
Route::post('/adddepartment',[DepartmentController::class,'addDepartment']);


// EmployeeController route

Route::get('/dashboard',[EmployeeController::class,'dashboard'])->middleware('auth');
Route::get('employee/create',[EmployeeController::class,'create'])->middleware('admin');
Route::post('employee/store',[EmployeeController::class,'store'])->middleware('auth');
Route::get('/employee/delete/{id}',[EmployeeController::class,'delete'])->middleware('admin');

//  add edit routes

Route::get('/employee/edit/{id}',[EmployeeController::class,'edit'])->middleware('admin');
Route::post('/employee/update/{id}',[EmployeeController::class,'update'])->middleware('admin');