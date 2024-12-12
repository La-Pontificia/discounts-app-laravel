@extends('layouts.dashboard')

@section('title', 'Reportes de descuentos aplicados')

@section('dashboard-content')
    <div class="flex flex-col space-y-4 flex-grow">
        <nav>
            <h2 class="text-xl text-center uppercase font-semibold tracking-tight">
                Reportes de descuentos aplicados
            </h2>
            <nav class="flex items-end gap-4 border-b pb-2 rounded-sm">
                <input type="search" value="{{ request()->get('q') }}" placeholder="Buscar" name="q"
                    class="dinamic-input-to-url">

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
        </nav>
        <div class="p-2">
            <div class="overflow-auto border bg-white p-3">
                <table class="w-full text-left">
                    <thead class="border-b">
                        <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-2 font-medium">
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
                            <tr class="[&>td]:p-2 [&>td]:py-1  even:bg-stone-100 [&>td]:text-nowrap [&>td>p]:text-nowrap">
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
                                <td>{{ $history->discount->user->businessName }}</td>
                                <td>
                                    <span
                                        class="bg-purple-100 border border-purple-500 text-purple-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">
                                        {{ $history->discount->amount }}%
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <p>
                                            {{ $history->created_at->format('d/m/Y') }}
                                        </p>
                                        <p class="text-sm">
                                            {{ $history->created_at->diffForHumans() }}
                                        </p>
                                        {{-- time ago --}}
                                    </div>
                                </td>
                                <td></td>
                                {{-- <td>
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

                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <footer class="px-5 py-4">
                    {!! $histories->links() !!}
                </footer>
            </div>
        </div>
    </div>
@endsection
