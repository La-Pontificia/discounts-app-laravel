@php
    $phone = isset($business) ? $business->phone : '';
    $address = isset($business) ? $business->address : '';
    $businessName = isset($business) ? $business->businessName : '';
    $email = isset($business) ? $business->email : '';

@endphp

<label class="label">
    <span>Nombre de negocio</span>
    <input value="{{ $businessName }}" name="businessName" required>
</label>

<label class="label">
    <span>Telefono de contacto</span>
    <input value="{{ $phone }}" type="text" required name="phone">
</label>
<label class="label">
    <span>Dirección</span>
    <textarea value="{{ $address }}" name="address" required></textarea>
</label>

<label class="label">
    <span>Correo</span>
    <input value="{{ $email }}" type="email" name="email" required>
</label>

@if (!isset($business))
    <label class="label">
        <span>Nueva contraseña</span>
        <input type="password" name="password" required>
    </label>
@endif
