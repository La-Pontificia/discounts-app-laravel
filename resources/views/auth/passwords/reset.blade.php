@extends('layouts.login')

@section('header-title', 'Ingrese su nueva contraseña')

@section('login-content')
    <form method="POST" action="{{ route('password.update') }}" class="space-y-3">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

        <label class="label">
            <span>
                Nueva contraseña
            </span>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </label>

        <label class="label">
            <span>Confirmar contraseña</span>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">
        </label>

        <button type="submit"
            class="bg-cyan-950 border border-cyan-300 p-3 text-cyan-50 font-medium rounded-lg text-sm w-full">
            Restablecer contraseña
        </button>
        <a href="/login" class="text-sm block text-cyan-600 hover:underline mt-4">
            Volver al inicio de sesión.
        </a>
    </form>
@endsection
