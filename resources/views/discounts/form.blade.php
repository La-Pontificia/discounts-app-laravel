@php
    $amount = isset($discount) ? $discount->amount : '';
    $userId = isset($discount) ? $discount->userId : '';
@endphp

<div class="grid grid-cols-2 gap-4">
    <label class="label col-span-2">
        <span>Descuento (%)</span>
        <input value="{{ $amount }}" min="1" max="100" type="number" name="amount" required>
    </label>
    <label class="label col-span-2">
        <span>Empresa</span>
        <select name="userId" required>
            <option value="">--Selecciona una empresa--</option>
            @foreach ($users as $user)
                <option @if ($userId == $user->id) selected @endif value="{{ $user->id }}">
                    {{ $user->businessName }}
                </option>
            @endforeach
        </select>
    </label>
</div>
