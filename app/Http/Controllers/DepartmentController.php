<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    function addDepartment(Request $req){

        $req->validate([  

            'department_name'=>'required'

        ]);

        Department::create([

            'department_name'=>$req->department_name

        ]);

        return "Department Added Successfully";

    }
}
