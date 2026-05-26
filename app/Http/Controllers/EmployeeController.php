<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function dashboard(Request $request)
    {
        $search = $request->search;

        $employees = Employee::with('department')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($employeeQuery) use ($search) {
                    $employeeQuery->where('id', 'LIKE', "%{$search}%")
                        ->orWhere('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('role', 'LIKE', "%{$search}%")
                        ->orWhereHas('department', function ($departmentQuery) use ($search) {
                            $departmentQuery->where('department_name', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(5);

        $totalEmployees = Employee::count();
        $totalDepartments = Department::count();
        $highestSalary = Employee::max('salary') ?? 0;
        $averageSalary = Employee::avg('salary') ?? 0;
        $role = Auth::user()->role;
        $pageTitle = match ($role) {
            'admin' => 'Admin Dashboard',
            'hr' => 'HR Dashboard',
            default => 'Employee Dashboard',
        };
        $canManageEmployees = $role === 'admin';

        return view('dashboard', compact(
            'averageSalary',
            'canManageEmployees',
            'employees',
            'highestSalary',
            'pageTitle',
            'role',
            'search',
            'totalDepartments',
            'totalEmployees'
        ));
    }

    public function apiDashboard()
    {
        return response()->json(Employee::with('department')->paginate(5));
    }

    public function create()
    {
        $departments = Department::all();

        return view('employee-create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email|unique:users,email',
            'salary' => 'required|numeric|min:0',
            'department_id' => 'required|exists:departments,id',
            'role' => 'required|in:admin,hr,employee',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $imageName = $this->storeImage($request);

        Employee::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'salary' => $validated['salary'],
            'department_id' => $validated['department_id'],
            'role' => $validated['role'],
            'image' => $imageName,
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Employee account created successfully.');
    }

    public function delete($id)
    {
        $employee = Employee::findOrFail($id);

        User::where('email', $employee->email)->delete();

        if ($employee->image && file_exists(public_path('employees/' . $employee->image))) {
            unlink(public_path('employees/' . $employee->image));
        }

        $employee->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Employee deleted successfully.');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departments = Department::all();
        $loginUser = User::where('email', $employee->email)->first();

        return view('employee-edit', compact('departments', 'employee', 'loginUser'));
    }

    public function apiEmployees()
    {
        return Employee::paginate(5);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $loginUser = User::where('email', $employee->email)->first();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignore($employee->id),
                Rule::unique('users', 'email')->ignore($loginUser?->id),
            ],
            'salary' => 'required|numeric|min:0',
            'department_id' => 'required|exists:departments,id',
            'role' => 'required|in:admin,hr,employee',
            'password' => [$loginUser ? 'nullable' : 'required', 'string', 'min:6', 'confirmed'],
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $imageName = $employee->image;

        if ($request->hasFile('image')) {
            if ($employee->image && file_exists(public_path('employees/' . $employee->image))) {
                unlink(public_path('employees/' . $employee->image));
            }

            $imageName = $this->storeImage($request);
        }

        $employee->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'salary' => $validated['salary'],
            'department_id' => $validated['department_id'],
            'role' => $validated['role'],
            'image' => $imageName,
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($validated['password']);
        }

        if ($loginUser) {
            $loginUser->update($userData);
        } else {
            $userData['password'] = Hash::make($validated['password']);
            User::create($userData);
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Employee account updated successfully.');
    }

    private function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('employees'), $imageName);

        return $imageName;
    }
}
