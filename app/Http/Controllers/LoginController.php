<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/';

    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->with(['error' => 'No se encontro nongun usuario'])->onlyInput('email');
        }

        if (!$user->status) {
            return back()->with(['error' => 'Tu cuenta no está activa. Comunícate con el administrador.'])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            $req->session()->regenerate();
            $user->lastSession = now();
            $user->save();
            return redirect()->intended('/');
        }

        return back()->with(['error' => 'Credenciales incorrectas'])->onlyInput('email');
    }
}
