<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiController extends Controller
{
    public function apiDashboard(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $this->dashboardData($request),
        ]);
    }

    public function apiRoleDashboard(Request $request, string $role)
    {
        return response()->json([
            'success' => true,
            'role' => $role,
            'data' => $this->dashboardData($request),
        ]);
    }

    public function apiEmployees(Request $request)
    {
        $employees = Employee::with('department')
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

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
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $employees,
        ]);
    }

    public function apiSingleEmployee($id)
    {
        $employee = Employee::with('department')->find($id);

        if (! $employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $employee,
        ]);
    }

    public function apiStoreEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email|unique:users,email',
            'salary' => 'required|numeric|min:0',
            'department_id' => 'required|exists:departments,id',
            'role' => 'required|in:admin,hr,employee',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $imageName = $this->storeImage($request);

        $employee = Employee::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'salary' => $validated['salary'],
            'department_id' => $validated['department_id'],
            'role' => $validated['role'],
            'image' => $imageName,
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Employee and login account created successfully.',
            'data' => [
                'employee' => $employee->load('department'),
                'user' => $user,
            ],
        ], 201);
    }

    public function apiUpdateEmployee(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (! $employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found.',
            ], 404);
        }

        $loginUser = User::where('email', $employee->email)->first();

        $validator = Validator::make($request->all(), [
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

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
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
            $user = $loginUser->fresh();
        } else {
            $userData['password'] = Hash::make($validated['password']);
            $user = User::create($userData);
        }

        return response()->json([
            'success' => true,
            'message' => 'Employee and login account updated successfully.',
            'data' => [
                'employee' => $employee->fresh('department'),
                'user' => $user,
            ],
        ]);
    }

    public function apiDeleteEmployee($id)
    {
        $employee = Employee::find($id);

        if (! $employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found.',
            ], 404);
        }

        User::where('email', $employee->email)->delete();

        if ($employee->image && file_exists(public_path('employees/' . $employee->image))) {
            unlink(public_path('employees/' . $employee->image));
        }

        $employee->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee and login account deleted successfully.',
        ]);
    }

    public function apiSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'nullable|in:admin,hr,employee',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'employee',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully.',
            'data' => $user,
        ], 201);
    }

    public function apiLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'nullable|in:admin,hr,employee',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password.',
            ], 401);
        }

        $selectedRole = $validated['role'] ?? $request->route('role');

        if ($selectedRole && $user->role !== $selectedRole) {
            return response()->json([
                'success' => false,
                'message' => 'The selected login type does not match this account.',
            ], 403);
        }

        $token = $user->createToken('thunder-client-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'token_type' => 'Bearer',
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function apiMe(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    }

    public function apiLogout(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful.',
        ]);
    }

    public function apiDepartments()
    {
        return response()->json([
            'success' => true,
            'data' => Department::latest()->get(),
        ]);
    }

    public function apiSingleDepartment($id)
    {
        $department = Department::find($id);

        if (! $department) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $department,
        ]);
    }

    public function apiStoreDepartment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_name' => 'required|string|max:255|unique:departments,department_name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $department = Department::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Department added successfully.',
            'data' => $department,
        ], 201);
    }

    public function apiUpdateDepartment(Request $request, $id)
    {
        $department = Department::find($id);

        if (! $department) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found.',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'department_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments', 'department_name')->ignore($department->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $department->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Department updated successfully.',
            'data' => $department,
        ]);
    }

    public function apiDeleteDepartment($id)
    {
        $department = Department::find($id);

        if (! $department) {
            return response()->json([
                'success' => false,
                'message' => 'Department not found.',
            ], 404);
        }

        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully.',
        ]);
    }

    private function dashboardData(Request $request): array
    {
        return [
            'stats' => [
                'total_employees' => Employee::count(),
                'total_departments' => Department::count(),
                'highest_salary' => Employee::max('salary') ?? 0,
                'average_salary' => Employee::avg('salary') ?? 0,
            ],
            'employees' => Employee::with('department')
                ->when($request->search, function ($query) use ($request) {
                    $search = $request->search;

                    $query->where(function ($employeeQuery) use ($search) {
                        $employeeQuery->where('id', 'LIKE', "%{$search}%")
                            ->orWhere('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%")
                            ->orWhere('role', 'LIKE', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(10),
        ];
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
