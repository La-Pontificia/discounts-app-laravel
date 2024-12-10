@extends('layouts.dashboard')

@section('title', 'Descuentos de empresas')

@section('dashboard-content')
    <div class="flex flex-col flex-grow overflow-auto">
        <nav>
            <h2 class="text-xl text-center pb-2 uppercase font-semibold tracking-tight">
                Descuentos de empresas
            </h2>
            <nav class="flex items-center gap-2">
                <button type="button" data-modal-target="dialog" data-modal-toggle="dialog"
                    class="py-1.5 px-3 flex justify-center gap-2 items-center bg-green-800 border border-lime-400 rounded-md text-sm text-white">
                    @svg('fluentui-add-20', 'w-4 h-4')
                    <span>Registrar</span>
                </button>
                <div id="dialog" tabindex="-1" aria-hidden="true" class="dialog hidden">
                    <div class="content lg:max-w-lg max-w-full">
                        <header>
                            Registrar nuevo descuento
                        </header>
                        <form action="/discounts" method="POST" id="dialog-form" class="dinamic-form body grid gap-4 pb-5">
                            @include('discounts.form')
                        </form>
                        <footer>
                            <button data-modal-hide="dialog" type="button">Cancelar</button>
                            <button form="dialog-form" type="submit">
                                Registrar</button>
                        </footer>
                    </div>
                </div>

                <input type="search" value="{{ request()->get('q') }}" placeholder="Filtra descuentos" name="q"
                    class="dinamic-input-to-url">

                <button class="primary refresh-page">
                    @svg('fluentui-search-20', 'w-4 h-4')
                    <span>Filtrar</span>
                </button>
            </nav>
            <div class="p-2">
                <div class="overflow-auto border bg-white p-3">
                    <table class="w-full text-left">
                        <thead class="border-b">
                            <tr class="[&>th]:font-medium [&>th]:text-nowrap [&>th]:p-2 font-medium">
                                <th>N°</th>
                                <th>Descuento (%)</th>
                                <th>Empresa</th>
                                <th>Creado por</th>
                                <th>Registrado en</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($discounts as $index => $discount)
                                <tr class="[&>td]:p-2 even:bg-stone-100 [&>td]:text-nowrap [&>td>p]:text-nowrap">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $discount->amount . '%' }}</td>
                                    <td>{{ $discount->user->businessName }}</td>
                                    <td>{{ $discount->creator->displayName() }}</td>
                                    <td>
                                        <div>
                                            <p>
                                                {{ $discount->created_at->format('d/m/Y') }}
                                            </p>
                                            <p class="text-sm">
                                                {{ $discount->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <button
                                                class="dinamic-alert py-1 px-3 flex items-center gap-2 bg-red-800 border border-rose-400/20 rounded-md text-white text-sm"
                                                data-action="/discounts/{{ $discount->id }}/delete"
                                                data-title='Eliminar el descuento'
                                                data-description='¿Estás seguro de eliminar el descuento de {{ $discount->amount }}% de {{ $discount->user->businessName }}?'>
                                                @svg('fluentui-delete-20-o', 'w-4 h-4')
                                                Eliminar
                                            </button>
                                            <button data-modal-target="dialog-{{ $discount->id }}"
                                                data-modal-toggle="dialog-{{ $discount->id }}"
                                                class="px-2 py-1 flex items-center gap-2 text-sm rounded-md bg-green-800 border border-lime-500 text-white">
                                                @svg('fluentui-pen-20', 'w-4 h-4')
                                                Editar
                                            </button>
                                            <div id="dialog-{{ $discount->id }}" tabindex="-1" aria-hidden="true"
                                                class="dialog hidden">
                                                <div class="content lg:max-w-lg max-w-full">
                                                    <header>
                                                        Actualizar descuento
                                                    </header>
                                                    <form action="/discounts/{{ $discount->id }}" method="POST"
                                                        id="dialog-form-{{ $discount->id }}"
                                                        class="dinamic-form body grid gap-4 pb-5">
                                                        @include('discounts.form', [
                                                            'discount' => $discount,
                                                        ])
                                                    </form>
                                                    <footer>
                                                        <button data-modal-hide="dialog-{{ $discount->id }}"
                                                            type="button">Cancelar</button>
                                                        <button form="dialog-form-{{ $discount->id }}" type="submit">
                                                            Atualizar</button>
                                                    </footer>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <footer class="px-5 py-4">
                        {!! $discounts->links() !!}
                    </footer>
                </div>
            </div>
    </div>
@endsection
