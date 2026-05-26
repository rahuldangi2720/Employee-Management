<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function addDepartment(Request $req)
    {
        $req->validate([
            'department_name' => 'required|string|max:255|unique:departments,department_name',
        ]);

        Department::create([
            'department_name' => $req->department_name,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Department added successfully.');
    }
}
