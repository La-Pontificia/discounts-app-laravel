@extends('layouts.login')

@section('login-content')
    <form action="/login" method="POST" class="grid items-start rounded-xl gap-4">
        @csrf
        <label class="label">
            <span>Correo electronico</span>
            <input type="email" style="padding: 10px" name="email" placeholder="">
        </label>
        <label class="label">
            <span>Contraseña</span>
            <input style="padding: 10px" type="password" name="password" placeholder="">
        </label>
        <div>
            <a href="/password/reset" class="text-sm underline text-blue-600">
                ¿Olvidaste tu contraseña?
            </a>
        </div>
        <button type="submit" class="bg-cyan-950 border border-cyan-300 text-cyan-50 font-medium rounded-lg text-sm w-full"
            style="width: 100%; padding: 10px; justify-content: center">Iniciar sesion</button>
        @if (session('error'))
            <div class="text-sm max-w-max p-2 pt-5 text-red-600">
                {{ session('error') }}
            </div>
        @endif
    </form>
@endsection
