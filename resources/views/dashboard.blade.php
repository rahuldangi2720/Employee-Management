<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Dashboard</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gray-50 min-h-screen  overflow-x-hidden">

    <div class="max-w-7xl mx-auto p-4 lg:p-6">

        <!-- Header -->

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">

            <div>

                <h1 class="text-4xl font-extrabold text-blue-600">
                    Employee Dashboard
                </h1>

                <p class="text-gray-500 mt-2">
                    Manage all employees and departments
                </p>

            </div>

            <div class="flex gap-3">

                <a
                    href="/employee/create"

                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-sm transition duration-300">
                    + Add Employee
                </a>

                <a
                    href="/logout"

                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl font-semibold shadow-sm transition duration-300">
                    Logout
                </a>

            </div>

        </div>

        <!-- Main Dashboard Card -->

        <div class="bg-white shadow-lg rounded-3xl overflow-hidden border border-gray-100">

            <!-- Search Section -->

            <div class="px-6 py-5 border-b flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <h2 class="text-2xl font-bold text-gray-700">
                    Employee List
                </h2>

                <form action="/dashboard" method="get" class="flex gap-3">

                    <input
                        type="text"

                        name="search"

                        value="{{$search}}"

                        placeholder="Search employee..."

                        class="w-72 border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-200">

                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition duration-300">
                        Search
                    </button>

                </form>

            </div>

            <!-- Statistics Cards -->

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 p-6">

                <!-- Total Employees -->

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-gray-500">
                                Total Employees
                            </p>

                            <h2 class="text-3xl font-bold text-blue-600 mt-3">
                                {{$totalEmployees}}
                            </h2>

                        </div>

                        <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center text-2xl">
                            👨‍💼
                        </div>

                    </div>

                </div>

                <!-- Total Departments -->

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-gray-500">
                                Total Departments
                            </p>

                            <h2 class="text-3xl font-bold text-green-600 mt-3">
                                {{$totalDepartments}}
                            </h2>

                        </div>

                        <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center text-2xl">
                            🏢
                        </div>

                    </div>

                </div>

                <!-- Highest Salary -->

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-gray-500">
                                Highest Salary
                            </p>

                            <h2 class="text-3xl font-bold text-purple-600 mt-3">
                                ₹ {{number_format($highestSalary)}}
                            </h2>

                        </div>

                        <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center text-2xl">
                            💰
                        </div>

                    </div>

                </div>

                <!-- Average Salary -->

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-gray-500">
                                Average Salary
                            </p>

                            <h2 class="text-3xl font-bold text-red-500 mt-3">
                                ₹ {{number_format($averageSalary)}}
                            </h2>

                        </div>

                        <div class="w-14 h-14 rounded-xl bg-red-100 flex items-center justify-center text-2xl">
                            📊
                        </div>

                    </div>

                </div>

            </div>

            <!-- Table -->

            <div class="px-6 pb-6">

                <div>

                    <table class="w-full  text-left">

                        <thead class="bg-gray-100 text-gray-700 uppercase text-sm">

                            <tr>

                                <th class="px-6 py-4">
                                    ID
                                </th>

                                <th class="px-6 py-4">
                                    Name
                                </th>

                                <th class="px-6 py-4">
                                    Email
                                </th>

                                <th class="px-6 py-4">
                                    Salary
                                </th>

                                <th class="px-6 py-4">
                                    Department
                                </th>

                                <th class="px-6 py-4">
                                    Image
                                </th>

                                <th class="px-6 py-4 text-center">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($employees as $employee)

                            <tr class="border-b hover:bg-gray-50 transition duration-200">

                                <td class="px-6 py-5 font-semibold text-gray-700">
                                    {{$employee->id}}
                                </td>

                                <td class="px-6 py-5 font-semibold text-gray-800">
                                    {{$employee->name}}
                                </td>

                                <td class="px-6 py-5 text-gray-600 break-words max-w-[180px]">
                                    {{$employee->email}}
                                </td>

                                <td class="px-6 py-5 font-bold text-green-600">
                                    ₹ {{$employee->salary}}
                                </td>

                                <td class="px-6 py-5">

                                    <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm font-semibold">

                                        {{$employee->department->department_name}}

                                    </span>

                                </td>

                                <td class="px-6 py-5">

                                    <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm font-semibold">

                                      
                                        @if($employee->image)

                                        <img src="{{asset('employees/'.$employee->image)}}"
                                            class="w-14 h-14 rounded-full object-cover">

                                        @else

                                        <img src="https://ui-avatars.com/api/?name={{$employee->name}}"
                                            class="w-14 h-14 rounded-full">

                                        @endif
                                    </span>

                                </td>


                                <td class="px-6 py-5">

                                    <div class="flex items-center justify-center gap-2 flex-wrap">

                                        <a
                                            href="/employee/edit/{{$employee->id}}"

                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-5 py-2 rounded-xl font-semibold transition duration-300">
                                            Edit
                                        </a>

                                        <a
                                            href="/employee/delete/{{$employee->id}}"

                                            class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl font-semibold transition duration-300">
                                            Delete
                                        </a>

                                    </div>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->

                <div class="mt-8 flex justify-center">

                    {{$employees->links()}}

                </div>

            </div>

        </div>

    </div>

</body>

</html>