<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Employee</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gradient-to-br from-orange-100 to-orange-200 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-5xl bg-white shadow-2xl rounded-3xl overflow-hidden">

        <!-- Header -->
        <div class="bg-gradient-to-r from-yellow-500 to-orange-500 px-8 py-5">

            <h1 class="text-3xl font-bold text-white">
                ✏️ Edit Employee
            </h1>

            <p class="text-yellow-100 mt-1 text-sm">
                Update employee information and permissions
            </p>

        </div>

        <!-- Form Section -->
        <div class="p-8">

            <form 
                action="/employee/update/{{$employee->id}}" 
                method="POST" 
                enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-5">

                @csrf

                <!-- Employee Name -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Employee Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{$employee->name}}"

                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 
                        focus:outline-none focus:ring-4 focus:ring-yellow-200">

                </div>

                <!-- Email -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{$employee->email}}"

                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 
                        focus:outline-none focus:ring-4 focus:ring-yellow-200">

                </div>

                <!-- Salary -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Salary
                    </label>

                    <input
                        type="number"
                        name="salary"
                        value="{{$employee->salary}}"

                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 
                        focus:outline-none focus:ring-4 focus:ring-yellow-200">

                </div>

                <!-- Department -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Department
                    </label>

                    <select
                        name="department_id"

                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 bg-white
                        focus:outline-none focus:ring-4 focus:ring-yellow-200">

                        @foreach($departments as $department)

                        <option
                            value="{{$department->id}}"

                            {{$employee->department_id == $department->id ? 'selected' : ''}}>

                            {{$department->department_name}}

                        </option>

                        @endforeach

                    </select>

                </div>

                <!-- Role -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Employee Role
                    </label>

                    <select
                        name="role"

                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 bg-white 
                        focus:outline-none focus:ring-4 focus:ring-blue-200">

                        <option value="employee"
                            {{ $employee->role == 'employee' ? 'selected' : '' }}>
                            👨‍💼 Employee
                        </option>

                        <option value="hr"
                            {{ $employee->role == 'hr' ? 'selected' : '' }}>
                            🧑‍💻 HR Manager
                        </option>

                        <option value="admin"
                            {{ $employee->role == 'admin' ? 'selected' : '' }}>
                            👑 Administrator
                        </option>

                    </select>

                </div>

                <!-- Image -->
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Profile Image
                    </label>

                    <input 
                        type="file"
                        name="image"
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 bg-white">

                </div>

                <!-- Current Image -->
                @if($employee->image)

                <div class="md:col-span-2 flex items-center gap-4">

                    <img 
                        src="{{ asset('employees/'.$employee->image) }}"
                        class="w-20 h-20 rounded-2xl object-cover border shadow">

                    <div>

                        <p class="font-semibold text-gray-700">
                            Current Employee Image
                        </p>

                        <p class="text-sm text-gray-500">
                            Uploaded profile preview
                        </p>

                    </div>

                </div>

                @endif

                <!-- Buttons -->
                <div class="md:col-span-2 flex gap-4 pt-3">

                    <button
                        class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-500 
                        hover:from-yellow-600 hover:to-orange-600 
                        text-white py-3 rounded-xl font-semibold 
                        transition duration-300 shadow-md">

                        🚀 Update Employee

                    </button>

                    <a href="/dashboard"
                        class="flex-1 text-center bg-gray-100 hover:bg-gray-200 
                        text-gray-700 py-3 rounded-xl font-semibold 
                        transition duration-300 border border-gray-300">

                        ← Back Dashboard

                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>