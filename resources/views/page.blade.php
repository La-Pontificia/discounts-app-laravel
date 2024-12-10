@extends('layouts.dashboard')

@section('title', 'Inicio')

@section('dashboard-content')
    <div class="p-4 grid gap-4 max-w-md">
        <h2 class="text-lg font-semibold tracking-tight">
            Aplicar descuento
        </h2>
        <form id="query-document">
            <label for="" class="label">
                <span>
                    Documento (DNI)
                </span>
                <input style="padding: 15px; font-size: 16px" placeholder="999999999" type="number" name="slug">
                <p>
                    Ingrese el dni y presione Enter.
                </p>
            </label>
        </form>
        <form action="/history" method="POST" id="form-result"
            class="hidden data-[ready]:grid grid-cols-2 gap-4 dinamic-form">
            <label class="label col-span-2">
                <span>Documento de identidad</span>
                <input type="text" name="documentId" id="documentId" disabled>
            </label>
            <label class="label">
                <span>Nombres</span>
                <input type="text" name="firstNames" id="firstNames" disabled>
            </label>
            <label class="label">
                <span>Apellidos</span>
                <input type="text" id="lastNames" id="lastNames" disabled>
            </label>
            <label class="label col-span-2">
                <span>Unidad</span>
                <input type="text" id="businessUnit" id="businessUnit" disabled>
            </label>

            <div class="col-span-2 h-px bg-stone-500/20 w-full"></div>
            <label class="label col-span-2">
                <span>Descuento</span>
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
                <button class="primary" style="width: 100%;justify-content: center">
                    Aplicar descuento
                </button>
            </div>
        </form>
    </div>
@endsection
