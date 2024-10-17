<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Введенный email/пароль не найден.',
            ])->onlyInput('email');
        }

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'password' => 'Введенный email/пароль не найден.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        if ($user->is_admin) {
            return redirect()->intended('admin');
        }

        return redirect()->intended('user');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
