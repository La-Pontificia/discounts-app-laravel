<div>
    <label class="label cursor-pointer">
        <input type="file" data-label='label-upload'
            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
            name="file" required class="absolute upload-file opacity-0 pointer-events-none">
        <div
            class="w-full aspect-[10/8] border hover:bg-blue-500/10 hover:border-blue-600 rounded-xl text-center border-dashed p-2 grid place-content-center">
            <h1 id="label-upload" class="font-semibold text-lg tracking-tight">
                Selecciona un archivo CSV o Excel
            </h1>
            <p class="text-xs opacity-70">
                Descarga el formato de ejemplo.
            </p>
        </div>
    </label>
    <a href="/clients/example" class="text-blue-500 hover:underline">Descagar plantilla</a>
</div>
