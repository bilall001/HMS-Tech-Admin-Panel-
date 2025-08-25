<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('admin.pages.auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
<<<<<<< HEAD

            $user = Auth::user();

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Admin sees developers list
            } elseif ($user->role === 'developer') {
                return redirect()->route('developers.index'); // Developer sees own dashboard
            } elseif ($user->role === 'client') {
                return redirect()->route('client.dashboard'); // Client sees their dashboard
            } elseif ($user->role === 'team manager') {
                return redirect()->route('teamManager.dashboard'); // Client sees their dashboard
            } elseif ($user->role === 'partner') {
                return redirect()->route('admin.dashboard'); // Client sees their dashboard
            } elseif ($user->role === 'business developer') {
                return redirect()->route('business-developer.dashboard'); // ✅ new redirect
            }

=======

            $user = Auth::user();

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Admin sees developers list
            } elseif ($user->role === 'developer') {
                return redirect()->route('developers.index'); // Developer sees own dashboard
            } elseif ($user->role === 'client') {
                return redirect()->route('client.dashboard'); // Client sees their dashboard
            }
             elseif ($user->role === 'team manager') {
                return redirect()->route('teamManager.dashboard'); // Client sees their dashboard
            }
             elseif ($user->role === 'partner') {
                return redirect()->route('admin.index'); // Client sees their dashboard
            }elseif ($user->role === 'business developer') {
    return redirect()->route('business-developer.dashboard'); // ✅ new redirect
}

>>>>>>> a799297a4ac3a6e973e50e76357d1743c4f85579

            // Unknown role
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account does not have the correct role assigned.',
            ]);
        }

        // Invalid credentials
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    // Logout method
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
