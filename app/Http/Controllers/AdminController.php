<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function store(Request $request)
    {
        // 1️⃣ Validate input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2️⃣ Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Login successful');
        }

        // 3️⃣ Login failed
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput();
    }
}
