<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Department</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">
    <main class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-sky-700">Employee Management</p>
                <h1 class="mt-1 text-3xl font-bold text-slate-950">Add Department</h1>
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

        <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <form action="{{ route('departments.store') }}" method="post" class="space-y-5">
                @csrf

                <div>
                    <label for="department_name" class="mb-2 block text-sm font-semibold text-slate-700">Department Name</label>
                    <input
                        id="department_name"
                        type="text"
                        name="department_name"
                        value="{{ old('department_name') }}"
                        placeholder="For example, Human Resources"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                    >
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('dashboard') }}" class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-sky-700">
                        Save Department
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>

</html>
