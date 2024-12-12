@php
    $roles = [
        'admin' => 'Administrador',
        'admin-global' => 'Administrador global',
    ];

    $firstNames = isset($user) ? $user->firstNames : '';
    $lastNames = isset($user) ? $user->lastNames : '';
    $roleExternal = isset($user) ? $user->role : '';
    $email = isset($user) ? $user->email : '';

@endphp

<div class="grid grid-cols-2 gap-4">
    <label class="label">
        <span>Nombres</span>
        <input value="{{ $firstNames }}" type="text" name="firstNames" required>
    </label>
    <label class="label">
        <span>Apellidos</span>
        <input value="{{ $lastNames }}" type="text" name="lastNames">
    </label>
</div>

<label class="label">
    <span>Rol</span>
    <select name="role" required>
        <option value="">--Selecciona un rol--</option>
        @foreach ($roles as $key => $role)
            <option {{ $key == $roleExternal ? 'selected' : '' }} value="{{ $key }}">{{ $role }}
            </option>
        @endforeach
    </select>
</label>

<label class="label">
    <span>Correo</span>
    <input value="{{ $email }}" type="email" name="email" required>
</label>

@if (!isset($user))
    <label class="label">
        <span>Nueva contraseña</span>
        <input type="password" name="password" required>
    </label>
@endif
