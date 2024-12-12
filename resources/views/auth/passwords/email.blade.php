@extends('layouts.login')

@section('header-title', 'Restablecer contraseña')

@section('login-content')
    <div class="card-body">
        @if (session('status'))
            <div class="text-sm text-blue-500" role="alert">
                {{ session('status') == 'We have emailed your password reset link.' ? 'Le hemos enviado por correo electrónico el enlace para restablecer su contraseña.' : session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <label class="label">
                <span>
                    Ingresa tu correo electrónico.
                </span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                <p class="pb-5">
                    Por favor, ingrese su dirección de correo electrónico y le enviaremos un enlace para restablecer su
                    contraseña.
                </p>
                @error('email')
                    <span class="text-red-500 text-sm" role="alert">
                        {{ $message }}
                    </span>
                @enderror
            </label>

            <button type="submit"
                class="bg-cyan-950 border border-cyan-300 p-3 text-cyan-50 font-medium rounded-lg text-sm w-full">
                Enviar enlace.
            </button>

            <a href="/login" class="text-sm block text-cyan-600 hover:underline mt-4">
                Volver al inicio de sesión.
            </a>
        </form>
    </div>
@endsection
