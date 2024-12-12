@extends('layouts.dashboard')

@section('title', 'Reportes de descuentos aplicados')

@section('dashboard-content')
    <div class="flex flex-col space-y-4 flex-grow">
        <nav>
            <h2 class="text-xl text-center uppercase font-semibold tracking-tight">
                Reportes de descuentos aplicados
            </h2>
            <nav class="flex items-end flex-wrap gap-4 border-b pb-2 rounded-sm">
                {{-- <input type="search" value="{{ request()->get('q') }}" placeholder="Buscar" name="q"
                    class="dinamic-input-to-url"> --}}

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
                @if ($authUser->role != 'business')
                    <label class="label">
                        <span>
                            Empresa
                        </span>
                        <select name="businessId" class="dinamic-select-to-url">
                            <option value=""> -- Todas las empresas -- </option>
                            @foreach ($businesses as $business)
                                <option value="{{ $business->id }}"
                                    {{ request()->get('businessId') == $business->id ? 'selected' : '' }}>
                                    {{ $business->businessName }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                @endif
                <button class="primary refresh-page">
                    @svg('fluentui-search-20', 'w-4 h-4')
                    <span>Filtrar</span>
                </button>
                <div class="ml-auto">
                    <button id="export-button"
                        class="flex items-center gap-2 px-2 text-sm py-1.5 rounded-md bg-green-900 hover:bg-green-800 border border-lime-400 text-white">
                        @svg('fluentui-arrow-download-20-o', 'w-4 h-4')
                        <span>Exportar a Excel</span></span>
                    </button>
                </div>
            </nav>
        </nav>
        <div class="overflow-auto border bg-white">
            <table class="w-full text-left">
                <thead class="border-b">
                    <tr class="[&>th]:font-medium text-sm [&>th]:text-nowrap [&>th]:p-2 [&>th]:px-4 font-medium">
                        <th>N°</th>
                        <th>Cliente</th>
                        <th>Unidad</th>
                        <th>Negocio</th>
                        <th>Descuento</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($histories as $index => $history)
                        <tr
                            class="[&>td]:p-4 [&>td]:py-1 text-sm even:bg-stone-100 [&>td]:text-nowrap [&>td>p]:text-nowrap">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div>
                                    <p>{{ $history->client->displayName() }}</p>
                                    <p class="text-sm">{{ $history->client->documentId }}</p>
                                </div>
                            </td>
                            <td>
                                <p>
                                    @svg('fluentui-building-20-o', 'w-6 h-6 inline-block')
                                    {{ $history->client->businessUnit }}
                                </p>
                            </td>
                            <td>{{ $history->user->businessName }}</td>
                            <td>
                                <span
                                    class="bg-purple-100 border border-purple-500 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">
                                    {{ $history->amount }}%
                                </span>
                            </td>
                            <td>
                                <div>
                                    <p>
                                        {{ $history->created_at->format('d/m/Y') }}
                                    </p>
                                    <p class="text-xs opacity-60">
                                        {{ $history->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <footer class="px-5 py-4">
                {!! $histories->links() !!}
            </footer>
        </div>
    </div>
@endsection
