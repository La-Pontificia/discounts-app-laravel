@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('dashboard-content')
    <div class="grid gap-4">
        <div>
            <h2 class="text-lg font-semibold tracking-tight">
                Hola {{ $authUser->displayName() }},
                algunos graficos estadisticos disponibles.
            </h2>
            <p class="text-xs opacity-60 pb-2">
                Puedes filtrar los descuentos de empresas por rango de fechas.
            </p>
            <nav class="flex items-end gap-4 border-b pb-2 rounded-sm">
                <label class="label">
                    <span>
                        Fecha de inicio
                    </span>
                    <input type="date" value="{{ request()->get('startDate') }}" name="startDate"
                        class="dinamic-input-to-url">
                </label>
                <label class="label">
                    <span>
                        Fecha de fin
                    </span>
                    <input type="date" value="{{ request()->get('endDate') }}" name="endDate"
                        class="dinamic-input-to-url">
                </label>
                <button class="primary refresh-page">
                    @svg('fluentui-search-20', 'w-4 h-4')
                    <span>Filtrar</span>
                </button>
            </nav>
        </div>
        <div class="">
            <div id="history-dates">
            </div>
        </div>
        <div class="grid lg:grid-cols-2 gap-5 w-full">
            <div id="per-business-data" class="hadow-sm bg-white/70 border"></div>
            <div id="per-business-timeseries" class="shadow-sm bg-white/70 border"></div>
        </div>
        <div class="p-2">
            <h3 class="font-medium pt-3 pb-2">
                Últimos 10 descuentos aplicados.
            </h3>
            <div class="bg-white border w-full shadow-sm rounded-md">
                <table class="w-full">
                    <thead class="border-b">
                        <tr class="[&>td]:p-3 opacity-70 font-medium text-sm">
                            <td>#</td>
                            <td>ID</td>
                            <td>
                                Cliente
                            </td>
                            <td>
                                Empresa
                            </td>
                            <td>
                                Descuento
                            </td>
                            <td>
                                Hora
                            </td>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($histories as $index => $item)
                            <tr class="[&>td]:p-3 text-sm even:bg-stone-500/5 hover:bg-stone-500/10">
                                <td class="font-medium tracking-tight">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="font-medium">
                                    {{ $item->client->documentId }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $item->client->displayName() }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $item->user->businessName }}
                                </td>
                                <td>
                                    {{ $item->amount . '%' }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $item->created_at->format('H:i A') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
