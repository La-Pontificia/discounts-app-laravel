@extends('layouts.dashboard')

@section('title', 'Usuarios')

@section('dashboard-content')
    <div class="flex flex-col flex-grow overflow-auto">
        <nav>
            <h2 class="text-xl text-center pb-2 uppercase font-semibold tracking-tight">
                Gestión de usuarios
            </h2>
            <nav class="flex items-center gap-4">
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog"
                    class="py-1.5 px-3 flex justify-center gap-2 items-center bg-green-800 border border-lime-400 rounded-md text-sm text-white">
                    @svg('fluentui-add-20', 'w-4 h-4')
                    <span> Registrar usuario</span>
                </button>
                <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            Registrar nuevo usuario
                        </header>
                        <form action="/users" method="POST" id="dialog-form" class="dinamic-form body grid gap-4 pb-5">
                            @include('users.form')
                        </form>
                        <footer>
                            <button data-modal-hide="dialog" type="button">Cancelar</button>
                            <button form="dialog-form" type="submit">
                                Guardar</button>
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
                <table class="w-full text-left">
                    <thead class="border-b">
                        <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-2 font-medium">
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Razon Social</th>
                            <th>Rol</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>Ultimo acceso</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr class="[&>td]:p-2 even:bg-stone-100 [&>td]:text-nowrap [&>td>p]:text-nowrap">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->displayName() }}</td>
                                <td>{{ $user->businessName }}</td>
                                <td>
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                                        @svg('fluentui-person-20', 'w-4 h-4')
                                        {{ $user->roleDisplayName() }}
                                    </span>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    <p class="line-clamp-3 text-sm">
                                        {{ $user->address }}
                                    </p>
                                </td>
                                <td>
                                    <button data-action="/users/{{ $user->id }}/toggle-status"
                                        data-title="{{ $user->status ? 'Deshabilitar' : 'Habilitar' }} usuario {{ $user->displayName() }}"
                                        data-description="¿Estás seguro de {{ $user->status ? 'deshabilitar' : 'habilitar' }}  el usuario?"
                                        class="dinamic-alert flex items-center bg-white rounded-md border p-1 px-2 gap-2 font-semibold text-sm">
                                        @if ($user->status)
                                            <span class="text-green-500">
                                                @svg('fluentui-circle-half-fill-20', 'w-4 h-4')
                                            </span>
                                        @else
                                            <span class="text-red-500">
                                                @svg('fluentui-circle-half-fill-20', 'w-4 h-4')
                                            </span>
                                        @endif
                                        {{ $user->status ? 'Activo' : 'Inactivo' }}
                                    </button>
                                </td>
                                <td>
                                    <p class="text-sm">
                                        @svg('fluentui-person-clock-20-o', 'w-4 h-4 inline-block')
                                        {{ $user->lastSession ? $user->lastSession->format('d/m/Y H:i') : '-' }}
                                    </p>
                                </td>
                                <td>
                                    <button data-modal-target="dialog-{{ $user->id }}"
                                        data-modal-toggle="dialog-{{ $user->id }}"
                                        class="px-2 py-1 rounded-md bg-green-800 border border-lime-500 text-white">
                                        @svg('fluentui-pen-20', 'w-4 h-4')
                                    </button>
                                    <div id="dialog-{{ $user->id }}" tabindex="-1" aria-hidden="true"
                                        class="dialog hidden">
                                        <div class="content lg:max-w-lg max-w-full">
                                            <header>
                                                Actualizar usuario {{ $user->displayName() }}
                                            </header>
                                            <form action="/users/{{ $user->id }}" method="POST"
                                                id="dialog-form-{{ $user->id }}"
                                                class="dinamic-form body grid gap-4 pb-5">
                                                @include('users.form', [
                                                    'user' => $user,
                                                ])
                                            </form>
                                            <footer>
                                                <button data-modal-hide="dialog-{{ $user->id }}"
                                                    type="button">Cancelar</button>
                                                <button form="dialog-form-{{ $user->id }}" type="submit">
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
                    {!! $users->links() !!}
                </footer>
            </div>
        </div>
    </div>
@endsection
