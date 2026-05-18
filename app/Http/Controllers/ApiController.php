<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\support\Facades\view;  // use for check view exits or not
use Illuminate\support\Facades\Auth;


class ApiController extends Controller
{
     function apiDashboard()
    {

        $employees = Employee::with('department')
            ->paginate(5);

        return response()->json($employees);
    }



    // =========================
    // GET ALL EMPLOYEES API
    // =========================

    function apiEmployees()
    {

        $employees = Employee::with('department')
            ->paginate(5);

        return response()->json($employees);
    }



    // =========================
    // GET SINGLE EMPLOYEE API
    // =========================

    function apiSingleEmployee($id)
    {

        $employee = Employee::with('department')
            ->find($id);

        if (!$employee) {

            return response()->json([

                'success' => false,
                'message' => 'Employee Not Found'

            ], 404);
        }

        return response()->json([

            'success' => true,
            'data' => $employee

        ]);
    }



    // =========================
    // STORE EMPLOYEE API
    // =========================

    function apiStoreEmployee(Request $req)
    {

        $req->validate([

            'name' => 'required',
            'email' => 'required|email',
            'salary' => 'required',
            'department_id' => 'required'

        ]);

        $employee = Employee::create([

            'name' => $req->name,
            'email' => $req->email,
            'salary' => $req->salary,
            'department_id' => $req->department_id

        ]);

        return response()->json([

            'success' => true,
            'message' => 'Employee Added Successfully',
            'data' => $employee

        ]);
    }



    // =========================
    // UPDATE EMPLOYEE API
    // =========================

    function apiUpdateEmployee(Request $req, $id)
    {

        $employee = Employee::find($id);

        if (!$employee) {

            return response()->json([

                'success' => false,
                'message' => 'Employee Not Found'

            ], 404);
        }

        $employee->update([

            'name' => $req->name,
            'email' => $req->email,
            'salary' => $req->salary,
            'department_id' => $req->department_id

        ]);

        return response()->json([

            'success' => true,
            'message' => 'Employee Updated Successfully',
            'data' => $employee

        ]);
    }



    // =========================
    // DELETE EMPLOYEE API
    // =========================

    function apiDeleteEmployee($id)
    {

        $employee = Employee::find($id);

        if (!$employee) {

            return response()->json([

                'success' => false,
                'message' => 'Employee Not Found'

            ], 404);
        }

        $employee->delete();

        return response()->json([

            'success' => true,
            'message' => 'Employee Deleted Successfully'

        ]);
    }



    // ==========================================
// API SIGNUP
// ==========================================

function apiSignup(Request $req){

    $req->validate([

        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required'

    ]);

    $user = User::create([

        'name' => $req->name,
        'email' => $req->email,
        'password' => Hash::make($req->password)

    ]);

    return response()->json([

        'success' => true,
        'message' => 'User Registered Successfully',
        'data' => $user

    ]);

}



// ==========================================
// API LOGIN
// ==========================================

function apiLogin(Request $req){

    $credentials = $req->validate([

        'email' => 'required|email',
        'password' => 'required'

    ]);

 

    if(Auth::attempt($credentials)){
        $user = Auth::user();
        $token = $user->createToken('mytoken')->plainTextToken;

        return response()->json([

            'success' => true,
            'message' => 'Login Successful',
            'token' => $token,
            'user'=> $user
            // 'user' => Auth::user()

        ]);

    }else{

        return response()->json([

            'success' => false,
            'message' => 'Invalid Email or Password'

        ],401);

    }

}



// ==========================================
// API LOGOUT
// ==========================================

function apiLogout(){

    Auth::logout();

    request()->session()->invalidate();

    request()->session()->regenerateToken();

    return response()->json([

        'success' => true,
        'message' => 'Logout Successful'

    ]);

}

 // ==========================================
    // GET ALL DEPARTMENTS API
    // ==========================================

    function apiDepartments(){

        $departments = Department::all();

        return response()->json([

            'success' => true,
            'data' => $departments

        ]);

    }



    // ==========================================
    // GET SINGLE DEPARTMENT API
    // ==========================================

    function apiSingleDepartment($id){

        $department = Department::find($id);

        if(!$department){

            return response()->json([

                'success' => false,
                'message' => 'Department Not Found'

            ],404);

        }

        return response()->json([

            'success' => true,
            'data' => $department

        ]);

    }



    // ==========================================
    // STORE DEPARTMENT API
    // ==========================================

    function apiStoreDepartment(Request $req){

        $req->validate([

            'department_name' => 'required'

        ]);

        $department = Department::create([

            'department_name' => $req->department_name

        ]);

        return response()->json([

            'success' => true,
            'message' => 'Department Added Successfully',
            'data' => $department

        ]);

    }



    // ==========================================
    // UPDATE DEPARTMENT API
    // ==========================================

    function apiUpdateDepartment(Request $req,$id){

        $department = Department::find($id);

        if(!$department){

            return response()->json([

                'success' => false,
                'message' => 'Department Not Found'

            ],404);

        }

        $department->update([

            'department_name' => $req->department_name

        ]);

        return response()->json([

            'success' => true,
            'message' => 'Department Updated Successfully',
            'data' => $department

        ]);

    }



    // ==========================================
    // DELETE DEPARTMENT API
    // ==========================================

    function apiDeleteDepartment($id){

        $department = Department::find($id);

        if(!$department){

            return response()->json([

                'success' => false,
                'message' => 'Department Not Found'

            ],404);

        }

        $department->delete();

        return response()->json([

            'success' => true,
            'message' => 'Department Deleted Successfully'

        ]);

    }

}

