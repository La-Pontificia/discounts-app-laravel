@extends('layouts.app')

@section('content')
    <div class="w-full flex space-y-3 h-svh">
        <div class="h-full">
            <img src="/_background.webp" class="h-full object-cover" alt="">
        </div>
        <div class="p-10 flex flex-col h-full">
            <header class=" text-center space-y-4">
                <img src="/elp.webp" style="width: 100px; height: auto;" class="mx-auto" alt="">
                <h2 class="text-2xl font-bold tracking-tight">Descuentos</h2>
                <p class="opacity-70">
                    Por favor ingrese sus credenciales para acceder al sistema.
                </p>
            </header>
            <form action="/login" method="POST" class="grid items-start p-2 rounded-xl gap-4">
                @csrf
                <label class="label">
                    <span>Correo electronico</span>
                    <input type="email" name="email" placeholder="">
                </label>
                <label class="label">
                    <span>Contraseña</span>
                    <input type="password" name="password" placeholder="">
                </label>
                <button type="submit" class="primary w-full"
                    style="width: 100%; padding: 10px; justify-content: center">Iniciar sesion</button>
            </form>
            @if (session('error'))
                <div class="text-sm max-w-max p-2 text-red-600">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
@endsection
