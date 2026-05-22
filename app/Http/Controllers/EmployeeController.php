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


        
    } // with('department') Automatically related department fetch karega.


    function apiDashboard(){

    $employees = Employee::with('department')
                    ->paginate(5);

    return response()->json($employees);

}


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
            'department_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $imageName = null;

        if ($req->hasFile('image')) {

            $imageName = time() . '.' . $req->image->extension();

            $req->image->move(public_path('employees'), $imageName);
        }

        // for data save 

        Employee::create([
            'name' => $req->name,
            'email' => $req->email,
            'salary' => $req->salary,
            'department_id' => $req->department_id,
            'image' => $imageName

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

    function apiEmployees(){

    return Employee::paginate(5);

}
    // update  information

    function update(Request $req, $id)
    {


        $req->validate([
            'name' => 'required',
            'email' => 'required|email',
            'salary' => 'required',
            'department_id' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $employee = Employee::find($id);
        $imageName = $employee->image;

        if ($req->hasFile('image')) {

            // old image delete

            if ($employee->image && file_exists(public_path('employees/' . $employee->image))) {

                unlink(public_path('employees/' . $employee->image));
            }

            // new image upload

            $imageName = time() . '.' . $req->image->extension();

            $req->image->move(public_path('employees'), $imageName);
        }
        $employee->update([

            'name' => $req->name,
            'email' => $req->email,
            'salary' => $req->salary,
            'department_id' => $req->department_id,
            'image' => $imageName,
            'role' => $req->role

        ]);

        return redirect('/dashboard');
    }

    // SQL BEHIND THIS

    //Laravel internally runs:

    //UPDATE employees
    //SET name='Rahul'
    //WHERE id=1
}
