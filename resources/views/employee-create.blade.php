<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Employee</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-5xl bg-white shadow-2xl rounded-3xl overflow-hidden">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-5">

            <h1 class="text-3xl font-bold text-white">
                ➕ Add Employee
            </h1>

            <p class="text-blue-100 mt-1 text-sm">
                Create and manage employee records professionally
            </p>

        </div>

        <!-- Form -->
        <div class="p-8">

            <!-- Validation Errors -->
            @if($errors->any())

            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-xl">

                <ul class="list-disc ml-5">

                    @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

            @endif

            <form 
                action="/employee/store" 
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
                        placeholder="Enter employee name"

                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 
                        focus:outline-none focus:ring-4 focus:ring-blue-200">

                </div>

                <!-- Email -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="Enter email address"

                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 
                        focus:outline-none focus:ring-4 focus:ring-blue-200">

                </div>

                <!-- Salary -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Salary
                    </label>

                    <input
                        type="number"
                        name="salary"
                        placeholder="Enter salary"

                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 
                        focus:outline-none focus:ring-4 focus:ring-blue-200">

                </div>

                <!-- Department -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Department
                    </label>

                    <select
                        name="department_id"

                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 
                        bg-white focus:outline-none focus:ring-4 focus:ring-blue-200">

                        <option value="">
                            Select Department
                        </option>

                        @foreach($departments as $department)

                        <option value="{{$department->id}}">

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

                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 
                        bg-white focus:outline-none focus:ring-4 focus:ring-indigo-200">

                        <option value="employee">
                            👨‍💼 Employee
                        </option>

                        <option value="hr">
                            🧑‍💻 HR Manager
                        </option>

                        <option value="admin">
                            👑 Administrator
                        </option>

                    </select>

                </div>

                <!-- Image -->
                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Employee Image
                    </label>

                    <input 
                        type="file"
                        name="image"

                        class="w-full border border-gray-300 rounded-xl px-4 py-2 bg-white">

                </div>

                <!-- Buttons -->
                <div class="md:col-span-2 flex gap-4 pt-3">

                    <button
                        class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 
                        hover:from-blue-700 hover:to-indigo-700 
                        text-white py-3 rounded-xl font-semibold 
                        transition duration-300 shadow-md">

                        🚀 Add Employee

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