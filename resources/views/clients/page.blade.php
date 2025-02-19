@extends('layouts.dashboard')

@section('title', 'Clientes')

@section('dashboard-content')

    @if ($authUser->role !== 'business')
        <div class="flex flex-col flex-grow overflow-auto">
            <nav>
                <h2 class="text-xl text-center pb-2 uppercase font-semibold tracking-tight">
                    Gestión de clientes
                </h2>
                <nav class="flex items-center gap-2">
                    <button type="button" data-modal-target="dialog" data-modal-toggle="dialog"
                        class="py-1.5 px-3 flex justify-center gap-2 items-center bg-green-800 border border-lime-400 rounded-md text-sm text-white">
                        @svg('fluentui-add-20', 'w-4 h-4')
                        <span>Registrar cliente</span>
                    </button>
                    <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                        <div class="content lg:max-w-lg max-w-full">
                            <header>
                                Registrar nuevo cliente
                            </header>
                            <form action="/clients" method="POST" id="dialog-form"
                                class="dinamic-form body grid gap-4 pb-5">
                                @include('clients.form')
                            </form>
                            <footer>
                                <button data-modal-hide="dialog" type="button">Cancelar</button>
                                <button form="dialog-form" type="submit">
                                    Registrar</button>
                            </footer>
                        </div>
                    </div>

                    {{-- IMPORT DIALOG --}}
                    <button type="button" data-modal-target="dialog-upload" data-modal-toggle="dialog-upload"
                        class="py-1.5 px-3 flex justify-center gap-2 items-center bg-rose-800 border border-rose-400 rounded-md text-sm text-white">
                        @svg('fluentui-arrow-circle-down-20-o', 'w-4 h-4')
                        <span>Importar clientes</span>
                    </button>

                    <div id="dialog-upload" tabindex="-1" aria-hidden="true" class="dialog hidden">
                        <div class="content lg:max-w-lg max-w-full">
                            <header>
                                Importar clientes
                            </header>
                            <form action="/clients/import" method="POST" id="dialog-form-upload"
                                class="dinamic-form body grid gap-4 pb-5">
                                @include('clients.upload')
                            </form>
                            <footer>
                                <button data-modal-hide="dialog-upload" type="button">Cancelar</button>
                                <button form="dialog-form-upload" type="submit">
                                    Importar</button>
                            </footer>
                        </div>
                    </div>

                    <input type="search" value="{{ request()->get('q') }}" placeholder="Filtra clientes" name="q"
                        class="dinamic-input-to-url">

                    <button class="primary refresh-page">
                        @svg('fluentui-search-20', 'w-4 h-4')
                        <span>Filtrar</span>
                    </button>
                </nav>
            </nav>
            <div class="p-2">
                <div class="overflow-auto border bg-white p-3">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b">
                            <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-2 font-medium">
                                <th>N°</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Documento de Identidad</th>
                                <th>La Pontifica-Cybernet</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $index => $client)
                                <tr class="[&>td]:p-2 even:bg-stone-100 [&>td]:text-nowrap [&>td>p]:text-nowrap">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $client->firstNames }}</td>
                                    <td>{{ $client->lastNames }}</td>
                                    <td>{{ $client->documentId }}</td>
                                    <td>{{ $client->businessUnit }}</td>
                                    <td>{{ $client->displayType() }}</td>
                                    <td>
                                        <button data-action="/clients/{{ $client->id }}/toggle-status"
                                            data-title="{{ $client->status ? 'Deshabilitar' : 'Habilitar' }} cliente {{ $client->displayName() }}"
                                            data-description="¿Estás seguro de {{ $client->status ? 'deshabilitar' : 'habilitar' }}  el cliente?"
                                            class="dinamic-alert">
                                            @if ($client->status)
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
                                        <button data-modal-target="dialog-{{ $client->id }}"
                                            data-modal-toggle="dialog-{{ $client->id }}"
                                            class="px-2 py-1 rounded-md bg-green-800 border border-lime-500 text-white">
                                            @svg('fluentui-pen-20', 'w-4 h-4')
                                        </button>
                                        <div id="dialog-{{ $client->id }}" tabindex="-1" aria-hidden="true"
                                            class="dialog hidden">
                                            <div class="content lg:max-w-lg max-w-full">
                                                <header>
                                                    Actualizar cliente {{ $client->displayName() }}
                                                </header>
                                                <form action="/clients/{{ $client->id }}" method="POST"
                                                    id="dialog-form-{{ $client->id }}"
                                                    class="dinamic-form body grid gap-4 pb-5">
                                                    @include('clients.form', [
                                                        'client' => $client,
                                                    ])
                                                </form>
                                                <footer>
                                                    <button data-modal-hide="dialog-{{ $client->id }}"
                                                        type="button">Cancelar</button>
                                                    <button form="dialog-form-{{ $client->id }}" type="submit">
                                                        Atualizar</button>
                                                </footer>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <footer class="px-5 py-4">
                        {!! $clients->links() !!}
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
