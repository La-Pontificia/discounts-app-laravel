@extends('layouts.dashboard')

@section('title', 'Empresas')

@section('dashboard-content')
    @if ($authUser->role !== 'business')
        <div class="flex flex-col flex-grow overflow-auto">
            <nav>
                <h2 class="text-xl text-center pb-2 uppercase font-semibold tracking-tight">
                    Gestión de empresas.
                </h2>
                <nav class="flex items-center gap-4">
                    <button type="button" data-modal-target="dialog" data-modal-toggle="dialog"
                        class="py-1.5 px-3 flex justify-center gap-2 items-center bg-green-800 border border-lime-400 rounded-md text-sm text-white">
                        @svg('fluentui-add-20', 'w-4 h-4')
                        <span>Registrar empresa</span>
                    </button>
                    <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                        <div class="content lg:max-w-lg max-w-full">
                            <header>
                                Registrar nueva empresa
                            </header>
                            <form action="/businesses" method="POST" id="dialog-form"
                                class="dinamic-form body grid gap-4 pb-5">
                                @include('businesses.form')
                            </form>
                            <footer>
                                <button data-modal-hide="dialog" type="button">Cancelar</button>
                                <button form="dialog-form" type="submit">
                                    Registrar</button>
                            </footer>
                        </div>
                    </div>

                    <input type="search" value="{{ request()->get('q') }}" placeholder="Buscar empresa" name="q"
                        class="dinamic-input-to-url">

                    <button class="primary refresh-page">
                        @svg('fluentui-search-20', 'w-4 h-4')
                        <span>Filtrar</span>
                    </button>
                </nav>
            </nav>
            <div class="pt-5">
                <div class="overflow-auto border bg-white p-3">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b">
                            <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-2 font-medium">
                                <th>N°</th>
                                <th>Razon Social</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Estado</th>
                                <th>Ultimo acceso</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($businesses as $index => $business)
                                <tr
                                    class="[&>td]:p-2 even:bg-stone-100 hover:bg-stone-500/10 [&>td]:text-nowrap [&>td>p]:text-nowrap">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $business->businessName }}</td>
                                    <td>{{ $business->email }}</td>
                                    <td>{{ $business->phone }}</td>
                                    <td>
                                        <p class="line-clamp-3 text-sm">
                                            {{ $business->address }}
                                        </p>
                                    </td>
                                    <td>
                                        <button data-action="/businesses/{{ $business->id }}/toggle-status"
                                            data-title="{{ $business->status ? 'Deshabilitar' : 'Habilitar' }} empresa {{ $business->businessName }}"
                                            data-description="¿Estás seguro de {{ $business->status ? 'deshabilitar' : 'habilitar' }}  la empresa?"
                                            class="dinamic-alert">
                                            @if ($business->status)
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
                                                    Activo
                                                </span>
                                            @else
                                                <span
                                                    class="bg-red-100 text-red-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                                    Inactivo
                                                </span>
                                            @endif
                                        </button>
                                    </td>
                                    <td>
                                        <p class="text-sm">
                                            @svg('fluentui-person-clock-20', 'w-4 h-4 inline-block')
                                            {{ $business->lastSession ? $business->lastSession->format('d/m/Y H:i') : '-' }}
                                        </p>
                                    </td>
                                    <td>
                                        <button data-modal-target="dialog-{{ $business->id }}"
                                            data-modal-toggle="dialog-{{ $business->id }}"
                                            class="px-2 py-1 rounded-md bg-green-800 border border-lime-500 text-white">
                                            @svg('fluentui-pen-20', 'w-4 h-4')
                                        </button>
                                        <div id="dialog-{{ $business->id }}" tabindex="-1" aria-hidden="true"
                                            class="dialog hidden">
                                            <div class="content lg:max-w-lg max-w-full">
                                                <header>
                                                    Actualizar empresa {{ $business->businessName }}
                                                </header>
                                                <form action="/businesses/{{ $business->id }}" method="POST"
                                                    id="dialog-form-{{ $business->id }}"
                                                    class="dinamic-form body grid gap-4 pb-5">
                                                    @include('businesses.form', [
                                                        'business' => $business,
                                                    ])
                                                </form>
                                                <footer>
                                                    <button data-modal-hide="dialog-{{ $business->id }}"
                                                        type="button">Cancelar</button>
                                                    <button form="dialog-form-{{ $business->id }}" type="submit">
                                                        Atualizar</button>
                                                </footer>
                                            </div>
                                        </div>

                                        <button title="Restablecer contraseña"
                                            data-action="/businesses/{{ $business->id }}/reset-password"
                                            data-title="Restablecer contraseña de {{ $business->businessName }}"
                                            data-description="¿Estás seguro de restablecer la contraseña de {{ $business->businessName }}?"
                                            class="px-2 py-1 rounded-md dinamic-alert bg-orange-800 border border-yellow-500 text-white">
                                            @svg('fluentui-person-key-20', 'w-4 h-4')
                                        </button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <footer class="px-5 py-4">
                        {!! $businesses->links() !!}
                    </footer>
                </div>
            </div>
        </div>
    @else
        <div class="flex flex-col flex-grow items-center justify-center h-full">
            <div class="text-center">
                <h2 class="text-sm font-semibold text-gray-800">
                    A donde vas, no puedes acceder a esta sección.
                </h2>
            </div>
        </div>
    @endif
@endsection
