<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,hr,employee',
        ]);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Invalid email or password.'])
                ->onlyInput('email', 'role');
        }

        $request->session()->regenerate();

        if (Auth::user()->role !== $validated['role']) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['role' => 'The selected login type does not match this account.'])
                ->onlyInput('email', 'role');
        }

        return redirect()
            ->route('dashboard')
            ->with('success', ucfirst($validated['role']) . ' login successful.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
