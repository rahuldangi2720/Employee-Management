<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-2xl bg-white shadow-2xl rounded-3xl overflow-hidden">

        <!-- Header -->
        <div class="bg-blue-600 px-10 py-8">

            <h1 class="text-4xl font-bold text-white">
                Add Employee
            </h1>

            <p class="text-blue-100 mt-2">
                Create and manage employee records professionally
            </p>

        </div>

        <!-- Form -->
        <div class="p-10">

            <!-- Validation Errors -->
            @if($errors->any())

            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-xl">

                <ul class="list-disc ml-5">

                    @foreach($errors->all() as $error)

                    <li>{{$error}}</li>

                    @endforeach

                </ul>

            </div>

            @endif

            <form action="/employee/store" method="post" enctype="multipart/form-data" class="space-y-6">

                @csrf

                <!-- Name -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Employee Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Enter employee name"
                        class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition">

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
                        class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition">

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
                        class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition">

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">

                        Employee Image

                    </label>

                    <input type="file"
                        name="image"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-white">

                </div>

                <!-- Department -->
                <div>

                    <label class="block text-gray-700 font-semibold mb-2">
                        Department
                    </label>

                    <select
                        name="department_id"
                        class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition bg-white">

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

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">

                    <button
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold transition duration-300 shadow-md hover:shadow-lg">
                        Add Employee
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