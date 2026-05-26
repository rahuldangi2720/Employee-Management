<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">
    <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-sky-700">Employee Management</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-950">Add Employee</h1>
            </div>

            <a href="{{ route('dashboard') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                Back to Dashboard
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <section class="rounded-lg border border-slate-200 bg-white shadow-sm">
            <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-5 p-5 sm:grid-cols-2">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Employee Name</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Full name"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                    >
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email Address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="name@company.com"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                    >
                </div>

                <div>
                    <label for="salary" class="mb-2 block text-sm font-semibold text-slate-700">Salary</label>
                    <input
                        id="salary"
                        type="number"
                        name="salary"
                        value="{{ old('salary') }}"
                        placeholder="Monthly salary"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                    >
                </div>

                <div>
                    <label for="department_id" class="mb-2 block text-sm font-semibold text-slate-700">Department</label>
                    <select
                        id="department_id"
                        name="department_id"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                    >
                        <option value="">Select department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                                {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="role" class="mb-2 block text-sm font-semibold text-slate-700">Login Role</label>
                    <select
                        id="role"
                        name="role"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                    >
                        <option value="employee" @selected(old('role', 'employee') === 'employee')>Employee</option>
                        <option value="hr" @selected(old('role') === 'hr')>HR</option>
                        <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                    </select>
                </div>

                <div>
                    <label for="image" class="mb-2 block text-sm font-semibold text-slate-700">Profile Image</label>
                    <input
                        id="image"
                        type="file"
                        name="image"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm file:mr-4 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-slate-700"
                    >
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Login Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Minimum 6 characters"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                    >
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Repeat password"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                    >
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-5 sm:col-span-2 sm:flex-row sm:justify-end">
                    <a href="{{ route('dashboard') }}" class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-sky-700">
                        Save Employee
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>

</html>
