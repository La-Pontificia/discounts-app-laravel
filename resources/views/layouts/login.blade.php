@extends('layouts.app')

@section('content')
    <div class="w-full flex bg-white min-h-auto md:h-svh">
        <div class="h-full hidden md:block">
            <img src="/night.webp" class="h-full object-cover" alt="">
        </div>
        <div class="flex flex-col min-w-full md:min-w-[500px] h-full">
            <header class="text-center space-y-4 pt-10">
                <img src="/lp.webp" style="width: 170px; height: auto;" class="mx-auto" alt="">
                <p class="opacity-70 text-sm">
                    @yield('header-title', 'Por favor ingrese sus credenciales para acceder al sistema.')
                </p>
            </header>
            <div class="flex flex-grow flex-col h-full">
                <div class="p-7 flex-grow">
                    @yield('login-content')
                </div>
                <footer class="bg-[#080c10] text-white/60 p-3 text-center text-xs">
                    <p class="">©<a href="https://lp.com.pe" class="hover:underline" target="_blank">LP</a>
                        {{ date('Y') }} All
                        rights reserved.</p>
                    <p class="pt-2">
                        Desarrollado por <a href="https://daustinn.com" target="_blank"
                            class="text-[#2462ff] hover:underline">Daustinn</a>
                    </p>
                </footer>
            </div>
        </div>
    </div>
@endsection
