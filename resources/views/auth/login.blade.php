@extends('layouts.app')

@section('content')
    <div class="w-full flex bg-white h-svh">
        <div class="h-full">
            <img src="/_background.webp" class="h-full object-cover" alt="">
        </div>
        <div class="flex min-w-[500px] flex-col h-full">
            <header class="text-center space-y-4 py-5">
                <img src="/lp.webp" style="width: 170px; height: auto;" class="mx-auto" alt="">
                <p class="opacity-70">
                    Por favor ingrese sus credenciales para acceder al sistema.
                </p>
            </header>
            <div class="p-7">
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
                        <a href="" class="text-sm underline">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                    <button type="submit" class="bg-cyan-700 text-white font-medium rounded-lg text-sm w-full"
                        style="width: 100%; padding: 15px; justify-content: center">Iniciar sesion</button>
                </form>
            </div>
            @if (session('error'))
                <div class="text-sm max-w-max p-2 text-red-600">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
@endsection
