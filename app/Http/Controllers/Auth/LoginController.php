<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->with('error', 'Credeniales incorrectas, Intente de nuevo.');
        }

        if (!$user->status) {
            return back()->with('error', 'Tu cuenta no está activa. Comunícate con el administrador.');
        }
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        return redirect('/login')->with('error', 'Credeniales incorrectas, Intente de nuevo.');
    }
}
