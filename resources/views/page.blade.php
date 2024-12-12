@extends('layouts.dashboard')

@section('title', 'Inicio')

@section('dashboard-content')
    <div class="flex gap-10 items-start">
        <div class="flex-grow">
            <div class="bg-white border w-full shadow-sm rounded-md">
                <h2
                    class="p-3 py-3 border-orange-500/30 bg-orange-500/10 text-orange-800 border-b font-semibold tracking-tight">
                    Aplicar descuento a cliente
                </h2>
                <form id="query-document" class="px-4 py-3">
                    <label for="" class="label w-[300px]">
                        <span>
                            Documento de Indentidad (DNI)
                        </span>
                        <input autofocus style="padding: 10px; font-size: 16px" placeholder="" type="number" name="slug">
                        <p>
                            Ingrese el DNI y presione Enter.
                        </p>
                    </label>
                </form>
                <form action="/histories" method="POST" id="form-result"
                    class="hidden data-[ready]:grid p-4 pt-0 grid-cols-2 max-w-xl gap-4 dinamic-form">
                    <input type="hidden" readonly name="clientId" id="clientId">
                    <div class="space-y-2 text-sm opacity-70">
                        <p>
                            <b>DNI: </b> <span id="documentId">72377685</span>
                        </p>
                        <p>
                            <b>Apellidos: </b> <span id="lastNames">Bendezú Ñahui</span>
                        </p>
                        <p>
                            <b>Nombres: </b> <span id="firstNames">Jorge Luis</span>
                        </p>
                        <p class="text-nowrap">
                            <b>Unidad de Negocio: </b> <span id="businessUnit">Caja Arequipa</span>
                        </p>
                        <p>
                            <b>Tipo: </b> <span id="type">Alumno</span>
                        </p>
                    </div>
                    <div class="col-span-2 h-px bg-stone-500/20 w-full"></div>
                    <label class="label col-span-2">
                        <span>Descuento a aplicar</span>
                        <select name="discountId" required>
                            @foreach ($discounts as $discount)
                                <option value="{{ $discount->id }}">
                                    ({{ $discount->amount . '%' }})
                                    - {{ $discount->user->businessName }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                    <div class="col-span-2">
                        <button
                            class="bg-lime-950 px-4 hover:bg-lime-900 w-fit text-blue-50 p-3 py-2 rounded-md border border-lime-400/80">
                            Aplicar descuento
                        </button>
                    </div>
                </form>
            </div>
            <p class="p-2 text-xs opacity-70">
                <b>Nota:</b> El descuento se aplicará a la próxima compra del cliente.
            </p>
            <div class="p-2">
                <h3 class="font-medium pt-3 pb-2">
                    Descuentos realizados el dia de hoy. {{ now()->format('d-m-Y') }}
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
                            @foreach ($nowHistories as $index => $item)
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
                                        {{ $item->discount->user->businessName }}
                                    </td>
                                    <td>
                                        {{ $item->discount->amount . '%' }}
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
        <div
            class="bg-violet-950 max-xl:hidden text-purple-100 border-violet-300 aspect-square border p-2 shadow-sm rounded-md w-[200px]">
            <h2 class="opacity-70 pt-6 tracking-tight text-center">
                Hoy dia: {{ now()->format('d-m-Y') }}
            </h2>
            <div class="text-center">
                <h2 class="font-bold py-2 text-7xl tracking-tighter">
                    {{ $nowHistories->count() }}
                </h2>
                <p class="opacity-70">
                    Clientes
                </p>
            </div>
        </div>
    </div>
@endsection
