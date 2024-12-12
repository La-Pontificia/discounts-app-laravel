@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('dashboard-content')
    <div class="grid gap-4">
        <div>
            <h2 class="text-lg font-semibold tracking-tight">
                Hola {{ $authUser->displayName() }},
                algunos graficos estadisticos disponibles.
            </h2>
            <p class="text-xs opacity-60">
                Puedes filtrar los descuentos de empresas por nombre de empresa, porcentaje de descuento, nombre del creador
                y
                fecha de registro.
            </p>
            <div class="pt-2">
                <select name="" id="">
                    <option value="">Todas las empresas</option>
                </select>
            </div>
        </div>
        <div class="">
            <div id="history-dates">

            </div>
        </div>
        <div class="grid grid-cols-2 gap-5 w-full">
            <div id="per-business-data" class=" hadow-sm bg-white/70 border"></div>
            <div id="per-business-timeseries" class="shadow-sm bg-white/70 border"></div>
        </div>
    </div>
@endsection
