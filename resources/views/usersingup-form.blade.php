<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinup Form</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <div class="min-h-screen flex items-center justify-center">

        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8">

            <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">
                User Signup
            </h1>

            @if($errors->any())

            <div class="mb-5 space-y-3">

                @foreach($errors->all() as $error)

                <div class="flex items-center gap-3 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-xl shadow-sm">

                    <span class="text-xl">
                        ⚠️
                    </span>

                    <span class="text-sm font-medium">
                        {{$error}}
                    </span>

                </div>

                @endforeach

            </div>

            @endif

            <form action="/adduser" method="post" class="space-y-5">

                @csrf

                <div>
                    <input
                        type="text"
                        placeholder="Enter user-name"
                        name="name"

                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <input
                        type="email"
                        placeholder="Enter user-email"
                        name="email"

                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <input
                        type="password"
                        placeholder="Enter user-password"
                        name="password"

                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <input
                        type="password"
                        placeholder="Confirm password"
                        name="password_confirmation"

                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <button
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition duration-300">
                        SignUp
                    </button>
                    <p class="text-center text-gray-600 mt-6">

                        Already have an account

                        <a href="/userlogin" class="text-indigo-600 font-semibold hover:underline">
                            Login
                        </a>

                    </p>

                </div>
        </div>

        </form>

    </div>

    </div>

</body>

</html>