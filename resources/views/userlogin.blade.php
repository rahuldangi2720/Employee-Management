<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management Login</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">
    <main class="flex min-h-screen items-center justify-center px-4 py-10">
        <section class="grid w-full max-w-5xl overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xl lg:grid-cols-[1fr_430px]">
            <div class="hidden bg-slate-950 p-10 text-white lg:flex lg:flex-col lg:justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-300">Employee Management System</p>
                    <h1 class="mt-5 max-w-lg text-4xl font-bold leading-tight">Secure access for admins, HR teams, and employees.</h1>
                    <p class="mt-5 max-w-md text-sm leading-6 text-slate-300">Manage employee records, departments, salaries, and account roles from one clean dashboard.</p>
                </div>

                <div class="grid grid-cols-3 gap-3 text-sm">
                    <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                        <p class="font-semibold text-white">Admin</p>
                        <p class="mt-1 text-xs text-slate-400">Full control</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                        <p class="font-semibold text-white">HR</p>
                        <p class="mt-1 text-xs text-slate-400">Team view</p>
                    </div>
                    <div class="rounded-lg border border-white/10 bg-white/5 p-4">
                        <p class="font-semibold text-white">Employee</p>
                        <p class="mt-1 text-xs text-slate-400">Self access</p>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8">
                <div class="mb-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">Welcome back</p>
                    <h2 class="mt-2 text-3xl font-bold text-slate-950">Sign in</h2>
                </div>

                @if (session('success'))
                    <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login.submit') }}" method="post" class="space-y-5">
                    @csrf

                    <div>
                        <label for="role" class="mb-2 block text-sm font-semibold text-slate-700">Login Type</label>
                        <select
                            id="role"
                            name="role"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm font-medium text-slate-900 outline-none transition focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                        >
                            <option value="admin" @selected(old('role') === 'admin')>Admin Login</option>
                            <option value="hr" @selected(old('role') === 'hr')>HR Login</option>
                            <option value="employee" @selected(old('role', 'employee') === 'employee')>Employee Login</option>
                        </select>
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email Address</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="name@company.com"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Enter password"
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-sky-500 focus:ring-4 focus:ring-sky-100"
                        >
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <label class="flex items-center gap-2 text-sm font-medium text-slate-600">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                class="h-4 w-4 rounded border-slate-300 text-sky-600 focus:ring-sky-500"
                            >
                            Remember me
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-sky-600 px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-200"
                    >
                        Login
                    </button>
                </form>
            </div>
        </section>
    </main>
</body>

</html>
