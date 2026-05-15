<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Employee;

class EmployeeController extends Controller
{
    function dashboard(Request $req)
    {

        $search = $req->search;

        $employees = Employee::with('department')

            ->when($search, function ($query) use ($search) {

                $query->where('id', 'LIKE', "%$search%")

                    ->orWhere('name', 'LIKE', "%$search%")

                    ->orWhere('email', 'LIKE', "%$search%");
            })

            ->paginate(5);


        //   dashboard statistics 

        $totalEmployees = Employee::count(); // SELECT COUNT(*) FROM employees;
        $totalDepartments = Department::count();

        $highestSalary = Employee::max('salary');  //SELECT MAX(salary) FROM employees;

        $averageSalary = Employee::avg('salary');

        return view('dashboard', compact(

            'employees',
            'search',

            'totalEmployees',
            'totalDepartments',
            'highestSalary',
            'averageSalary'

        ));


        return view('dashboard', compact('employees', 'search'));
    } // with('department') Automatically related department fetch karega.


    function create()
    {
        $departments = Department::all();
        return view('employee-create', compact('departments'));
    }    //  SELECT * FROM departments 



    // create store function 

    function store(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'email' => 'required|email',
            'salary' => 'required',
            'department_id' => 'required'
        ]);

        // for data save 

        Employee::create([
            'name' => $req->name,
            'email' => $req->email,
            'salary' => $req->salary,
            'department_id' => $req->department_id
        ]);

        return redirect('/dashboard');
    }

    // for deleteing employe data 

    function delete($id)
    {
        Employee::find($id)->delete();
        return redirect('/dashboard');
    }

    // for edit employee information 

    function edit($id)
    {
        $employee = Employee::find($id);
        $departments = Department::all();

        return view('employee-edit', compact('employee', 'departments'));
    }
    // update  information

    function update(Request $req, $id)
    {


        $req->validate([
            'name' => 'required',
            'email' => 'required|email',
            'salary' => 'required',
            'department_id' => 'required'
        ]);

        $employee = Employee::find($id);
        $employee->update([

            'name' => $req->name,
            'email' => $req->email,
            'salary' => $req->salary,
            'department_id' => $req->department_id

        ]);

        return redirect('/dashboard');
    }

    // SQL BEHIND THIS

    //Laravel internally runs:

    //UPDATE employees
    //SET name='Rahul'
    //WHERE id=1
}
