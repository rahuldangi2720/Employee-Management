<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-r from-blue-100 to-indigo-200">

<div class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">

        <h1 class="text-3xl font-bold text-center text-indigo-600 mb-6">
            User Login
        </h1>

        {{-- Validation Errors --}}
        @if($errors->any())

            <div class="mb-5 space-y-3">

                @foreach($errors->all() as $error)

                    <div class="flex items-center gap-3 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-xl shadow-sm">

                        <span class="text-lg">
                            ⚠️
                        </span>

                        <span class="text-sm font-medium">
                            {{$error}}
                        </span>

                    </div>

                @endforeach

            </div>

        @endif

        {{-- Login Form --}}
        <form action="/userlogin" method="post" class="space-y-5">

            @csrf

            {{-- Email --}}
            <div>

                <label class="block text-gray-700 mb-2 font-medium">
                    Email
                </label>

                <input 
                    type="email"
                    placeholder="Enter your email"
                    name="email"

                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                >

            </div>

            {{-- Password --}}
            <div>

                <label class="block text-gray-700 mb-2 font-medium">
                    Password
                </label>

                <input 
                    type="password"
                    placeholder="Enter your password"
                    name="password"

                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                >

            </div>

            {{-- Button --}}
            <div>

                <button 
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold text-lg shadow-md transition duration-300"
                >
                    Login
                </button>

            </div>

        </form>

        {{-- Signup Link --}}
        <p class="text-center text-gray-600 mt-6">

            Don't have an account?

            <a href="/userform" class="text-indigo-600 font-semibold hover:underline">
                Signup
            </a>

        </p>

    </div>

</div>

</body>
</html>