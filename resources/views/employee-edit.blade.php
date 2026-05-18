<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-2xl bg-white shadow-2xl rounded-3xl overflow-hidden">

        <!-- Header -->
        <div class="bg-yellow-500 px-10 py-8">

            <h1 class="text-4xl font-bold text-white">
                Edit Employee
            </h1>

            <p class="text-yellow-100 mt-2">
                Update employee information
            </p>

        </div>

        <!-- Form -->
        <div class="p-10">

            @if($errors->any())

            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-xl">

                <ul class="list-disc ml-5">

                    @foreach($errors->all() as $error)

                    <li>{{$error}}</li>

                    @endforeach

                </ul>

            </div>

            @endif

            <form action="/employee/update/{{$employee->id}}" method="post" enctype="multipart/form-data" class="space-y-6">

                @csrf

                <!-- Name -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Employee Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{$employee->name}}"

                        class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-yellow-500 transition">

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

                        class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-yellow-500 transition">

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

                        class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-yellow-500 transition">

                </div>

                <!-- Department -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Department
                    </label>

                    <select
                        name="department_id"

                        class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:outline-none focus:ring-4 focus:ring-yellow-200 focus:border-yellow-500 transition bg-white">

                        @foreach($departments as $department)

                        <option
                            value="{{$department->id}}"

                            {{$employee->department_id == $department->id ? 'selected' : ''}}>

                            {{$department->department_name}}

                        </option>

                        @endforeach

                    </select>

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">

                        Update Employee Image

                    </label>

                    <input type="file"
                        name="image"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white">
                    @if($employee->image)

                    <div class="mt-4">

                        <img src="{{asset('employees/'.$employee->image)}}"
                            class="w-24 h-24 rounded-full object-cover border">

                    </div>

                    @endif
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">

                    <button
                        class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-xl font-semibold transition duration-300 shadow-md">
                        Update Employee
                    </button>

                    <a href="/dashboard"
                        class="flex-1 text-center bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-xl font-semibold transition duration-300">

                        Back Dashboard

                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>