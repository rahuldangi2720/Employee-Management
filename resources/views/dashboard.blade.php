<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Dashboard</title>

    @vite('resources/css/app.css')

</head>

<body class="bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 min-h-screen overflow-x-hidden">

    <div class="max-w-[95%] 2xl:max-w-[1800px] mx-auto p-3 lg:p-5">

        <!-- Header -->

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-6">

            <div>

                <h1 class="text-4xl lg:text-5xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    Employee Dashboard
                </h1>

                <p class="text-gray-500 mt-2 text-base">
                    Manage employees, departments and company roles
                </p>

            </div>

            <div class="flex gap-3 flex-wrap">

                <!-- Add Employee -->

                <a
                    href="/employee/create"

                    class="{{ Auth::user()->role != 'admin' ? 'hidden' : '' }}
                    bg-gradient-to-r from-blue-600 to-indigo-600 
                    hover:from-blue-700 hover:to-indigo-700 
                    text-white px-5 py-2.5 rounded-2xl 
                    font-semibold shadow-lg hover:scale-105 
                    transition duration-300">

                    ➕ Add Employee

                </a>

                <!-- Logout -->

                <a
                    href="/logout"

                    class="bg-gradient-to-r from-red-500 to-red-600 
                    hover:from-red-600 hover:to-red-700 
                    text-white px-5 py-2.5 rounded-2xl 
                    font-semibold shadow-lg hover:scale-105 
                    transition duration-300">

                    Logout

                </a>

            </div>

        </div>

        <!-- Dashboard Card -->

        <div class="backdrop-blur-xl bg-white/80 shadow-2xl rounded-[24px] overflow-hidden border border-white/40">

            <!-- Search Section -->

            <div class="px-6 py-4 border-b border-gray-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                <h2 class="text-2xl font-bold text-gray-800">
                    👨‍💼 Employee List
                </h2>

                <form action="/dashboard" method="get" class="flex gap-3">

                    <input
                        type="text"

                        name="search"

                        value="{{$search}}"

                        placeholder="Search employee..."

                        class="w-72 border border-gray-300 rounded-2xl px-4 py-2.5 
                        focus:outline-none focus:ring-4 focus:ring-blue-200 bg-white shadow-sm">

                    <button
                        class="bg-gradient-to-r from-blue-600 to-indigo-600 
                        hover:from-blue-700 hover:to-indigo-700 
                        text-white px-5 py-2.5 rounded-2xl 
                        font-semibold transition duration-300 shadow-md">

                        Search

                    </button>

                </form>

            </div>

            <!-- Statistics -->

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 p-5">

                <!-- Total Employees -->

                <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-lg border border-white/40 p-4 hover:shadow-2xl hover:-translate-y-1 transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-gray-500">
                                Total Employees
                            </p>

                            <h2 class="text-2xl font-bold text-blue-600 mt-2">
                                {{$totalEmployees}}
                            </h2>

                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-xl">
                            👨‍💼
                        </div>

                    </div>

                </div>

                <!-- Departments -->

                <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-lg border border-white/40 p-4 hover:shadow-2xl hover:-translate-y-1 transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-gray-500">
                                Departments
                            </p>

                            <h2 class="text-2xl font-bold text-green-600 mt-2">
                                {{$totalDepartments}}
                            </h2>

                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-green-100 flex items-center justify-center text-xl">
                            🏢
                        </div>

                    </div>

                </div>

                <!-- Highest Salary -->

                <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-lg border border-white/40 p-4 hover:shadow-2xl hover:-translate-y-1 transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-gray-500">
                                Highest Salary
                            </p>

                            <h2 class="text-2xl font-bold text-purple-600 mt-2">
                                ₹ {{number_format($highestSalary)}}
                            </h2>

                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center text-xl">
                            💰
                        </div>

                    </div>

                </div>

                <!-- Average Salary -->

                <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-lg border border-white/40 p-4 hover:shadow-2xl hover:-translate-y-1 transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-gray-500">
                                Average Salary
                            </p>

                            <h2 class="text-2xl font-bold text-red-500 mt-2">
                                ₹ {{number_format($averageSalary)}}
                            </h2>

                        </div>

                        <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center text-xl">
                            📊
                        </div>

                    </div>

                </div>

            </div>

            <!-- Table Section -->

            <div class="px-4 pb-5">

                <div class="overflow-x-auto rounded-3xl border border-gray-200 shadow-sm">

                    <table class="w-full text-left">

                        <thead class="bg-gradient-to-r from-slate-100 to-blue-100 text-gray-700 uppercase text-sm tracking-wider">

                            <tr>

                                <th class="px-6 py-4">ID</th>

                                <th class="px-6 py-4">Name</th>

                                <th class="px-6 py-4">Email</th>

                                <th class="px-6 py-4">Salary</th>

                                <th class="px-6 py-4">Department</th>

                                <th class="px-6 py-4">Role</th>

                                <th class="px-6 py-4">Image</th>

                                <th class="{{Auth::user()->role == 'employee' ? 'hidden' : '' }} px-6 py-4 text-center">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($employees as $employee)

                            <tr class="border-b hover:bg-blue-50/60 transition duration-300">

                                <!-- ID -->

                                <td class="px-6 py-3 font-semibold text-gray-700">
                                    {{$employee->id}}
                                </td>

                                <!-- Name -->

                                <td class="px-6 py-3 font-bold text-gray-800">
                                    {{$employee->name}}
                                </td>

                                <!-- Email -->

                                <td class="px-6 py-3 text-gray-600 break-words max-w-[220px]">
                                    {{$employee->email}}
                                </td>

                                <!-- Salary -->

                                <td class="px-6 py-3 font-bold text-green-600">
                                    ₹ {{$employee->salary}}
                                </td>

                                <!-- Department -->

                                <td class="px-6 py-3">

                                    <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm font-semibold">

                                        {{$employee->department->department_name}}

                                    </span>

                                </td>

                                <!-- Role -->

                                <td class="px-6 py-3">

                                    @if($employee->role == 'admin')

                                    <span class="bg-red-100 text-red-600 px-4 py-2 rounded-full text-sm font-bold">
                                        👑 Admin
                                    </span>

                                    @elseif($employee->role == 'hr')

                                    <span class="bg-purple-100 text-purple-600 px-4 py-2 rounded-full text-sm font-bold">
                                        🧑‍💻 HR
                                    </span>

                                    @else

                                    <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-sm font-bold">
                                        👨‍💼 Employee
                                    </span>

                                    @endif

                                </td>

                                <!-- Image -->

                                <td class="px-6 py-3">

                                    @if($employee->image)

                                    <img 
                                        src="{{asset('employees/'.$employee->image)}}"
                                        class="w-12 h-12 rounded-2xl object-cover shadow-lg border-2 border-white">

                                    @else

                                    <img 
                                        src="https://ui-avatars.com/api/?name={{$employee->name}}"
                                        class="w-12 h-12 rounded-2xl shadow-lg border-2 border-white">

                                    @endif

                                </td>

                                <!-- Actions -->

                                <td class="px-6 py-3">

                                    <div class="flex items-center justify-center gap-2 flex-wrap">

                                        <!-- Edit -->

                                        <a
                                            href="/employee/edit/{{$employee->id}}"

                                            class="{{Auth::user()->role == 'employee' ? 'hidden' : '' }} 
                                            bg-gradient-to-r from-yellow-400 to-orange-400 
                                            hover:from-yellow-500 hover:to-orange-500 
                                            text-white px-4 py-2 rounded-2xl 
                                            font-semibold transition duration-300 shadow-md">

                                            Edit

                                        </a>

                                        <!-- Delete -->

                                        <a
                                            href="/employee/delete/{{$employee->id}}"

                                            class="{{Auth::user()->role == 'employee' ? 'hidden' : '' }} 
                                            bg-gradient-to-r from-red-500 to-pink-500 
                                            hover:from-red-600 hover:to-pink-600 
                                            text-white px-4 py-2 rounded-2xl 
                                            font-semibold transition duration-300 shadow-md">

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

                <div class="mt-6 flex justify-center">

                    {{$employees->links()}}

                </div>

            </div>

        </div>

    </div>

</body>

</html>