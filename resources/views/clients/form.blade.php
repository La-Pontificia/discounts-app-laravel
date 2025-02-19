@php
    $businessUnits = ['La Pontifica-Cybernet'];
    $clientTypes = ['docente', 'alumno', 'directivo', 'ppff'];

    $firstNames = isset($client) ? $client->firstNames : '';
    $lastNames = isset($client) ? $client->lastNames : '';
    $documentId = isset($client) ? $client->documentId : '';
    $businessUnit = isset($client) ? $client->businessUnit : '';
    $type = isset($client) ? $client->type : '';
    $status = isset($client) ? $client->status : true;

@endphp

<div class="grid grid-cols-2 gap-4">
    <label class="label">
        <span>Documento de Identidad</span>
        <input pattern="[0-9]{8}" value="{{ $documentId }}" type="text" name="documentId" required>
    </label>
</div>

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
    <span>Comunidad Educativa</span>
    <select name="businessUnit" required>
        <option value="">--Seleccionar--</option>
        @foreach ($businessUnits as $bu)
            <option value="{{ $bu }}" @if ($bu == $businessUnit) selected @endif>{{ $bu }}
            </option>
        @endforeach
    </select>
</label>

<label class="label">
    <span>Tipo de cliente</span>
    <select name="type" required>
        <option value="">--Selecciona un tipo--</option>
        @foreach ($clientTypes as $ct)
            <option value="{{ $ct }}" @if ($ct == $type) selected @endif>{{ $ct }}
            </option>
        @endforeach
    </select>
</label>


<label class="inline-flex items-center cursor-pointer">
    <input @if ($status) checked @endif name="status" type="checkbox" class="sr-only hidden peer">
    <div
        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
    </div>
    <span class="ms-3 text-sm font-medium text-gray-900">Estado</span>
</label>
