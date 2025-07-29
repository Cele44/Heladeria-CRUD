<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ])) {
            $request->session()->regenerate();

            if (Auth::user()->rol) {
                return redirect()->route('admin.dashboard')->with('success', '¡Bienvenido admin!');
            }

            return redirect()->intended(route('user.home'))->with('success', '¡Bienvenido de nuevo!');
        }

        return back()->withErrors(['email' => 'Credenciales inválidas.'])->withInput();
    }

    public function logout(Request $request)
    {
        $userId = Auth::id();
        $request->session()->forget("carrito.$userId"); // 🧹 limpiar carrito
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', '¡Hasta luego!');
    }
}
