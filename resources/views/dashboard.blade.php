<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="min-h-screen">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-sky-700">Employee Management System</p>
                    <h1 class="mt-1 text-2xl font-bold text-slate-950 sm:text-3xl">{{ $pageTitle }}</h1>
                    <p class="mt-1 text-sm text-slate-500">Signed in as {{ Auth::user()->name }} with {{ strtoupper($role) }} access.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    @if ($canManageEmployees)
                        <a
                            href="{{ route('departments.create') }}"
                            class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                        >
                            Add Department
                        </a>
                        <a
                            href="{{ route('employees.create') }}"
                            class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-sky-700"
                        >
                            Add Employee
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button
                            type="submit"
                            class="rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100"
                        >
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Total Employees</p>
                    <p class="mt-3 text-3xl font-bold text-slate-950">{{ $totalEmployees }}</p>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Departments</p>
                    <p class="mt-3 text-3xl font-bold text-emerald-700">{{ $totalDepartments }}</p>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Highest Salary</p>
                    <p class="mt-3 text-3xl font-bold text-amber-700">Rs {{ number_format($highestSalary) }}</p>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Average Salary</p>
                    <p class="mt-3 text-3xl font-bold text-indigo-700">Rs {{ number_format($averageSalary) }}</p>
                </div>
            </section>

            <section class="mt-6 rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-4 border-b border-slate-200 p-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-950">Employee Directory</h2>
                        <p class="mt-1 text-sm text-slate-500">Search, review, and manage employee login access.</p>
                    </div>

                    <form action="{{ route('dashboard') }}" method="get" class="flex w-full flex-col gap-3 sm:flex-row lg:w-auto">
                        <input
                            type="text"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search by name, email, role, department"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-100 sm:w-80"
                        >
                        <button
                            type="submit"
                            class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700"
                        >
                            Search
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[920px] text-left text-sm">
                        <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-4 py-3">Employee</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Department</th>
                                <th class="px-4 py-3">Salary</th>
                                <th class="px-4 py-3">Role</th>
                                @if ($canManageEmployees)
                                    <th class="px-4 py-3 text-right">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($employees as $employee)
                                <tr class="transition hover:bg-slate-50">
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($employee->image)
                                                <img
                                                    src="{{ asset('employees/' . $employee->image) }}"
                                                    alt="{{ $employee->name }}"
                                                    class="h-11 w-11 rounded-lg object-cover"
                                                >
                                            @else
                                                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-sky-100 text-sm font-bold text-sky-700">
                                                    {{ strtoupper(substr($employee->name, 0, 1)) }}
                                                </div>
                                            @endif

                                            <div>
                                                <p class="font-semibold text-slate-950">{{ $employee->name }}</p>
                                                <p class="text-xs text-slate-500">ID: {{ $employee->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-slate-600">{{ $employee->email }}</td>
                                    <td class="px-4 py-4">
                                        <span class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                            {{ optional($employee->department)->department_name ?? 'Unassigned' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 font-semibold text-slate-800">Rs {{ number_format($employee->salary) }}</td>
                                    <td class="px-4 py-4">
                                        @if ($employee->role === 'admin')
                                            <span class="rounded-md bg-red-50 px-2.5 py-1 text-xs font-bold text-red-700">Admin</span>
                                        @elseif ($employee->role === 'hr')
                                            <span class="rounded-md bg-indigo-50 px-2.5 py-1 text-xs font-bold text-indigo-700">HR</span>
                                        @else
                                            <span class="rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">Employee</span>
                                        @endif
                                    </td>

                                    @if ($canManageEmployees)
                                        <td class="px-4 py-4">
                                            <div class="flex justify-end gap-2">
                                                <a
                                                    href="{{ route('employees.edit', $employee->id) }}"
                                                    class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-100"
                                                >
                                                    Edit
                                                </a>
                                                <form action="{{ route('employees.delete', $employee->id) }}" method="post" onsubmit="return confirm('Delete this employee and login account?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100"
                                                    >
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $canManageEmployees ? 6 : 5 }}" class="px-4 py-12 text-center text-sm text-slate-500">
                                        No employees found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200 px-4 py-4">
                    {{ $employees->withQueryString()->links() }}
                </div>
            </section>
        </main>
    </div>
</body>

</html>
