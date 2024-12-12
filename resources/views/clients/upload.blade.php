<div>
    <label class="label cursor-pointer">
        <input type="file" data-label='label-upload'
            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
            name="file" required class="absolute upload-file opacity-0 pointer-events-none">
        <div
            class="w-full aspect-[10/8] border hover:bg-blue-500/10 hover:border-blue-600 rounded-xl text-center border-dashed p-2 grid place-content-center">
            <h1 id="label-upload" class="font-semibold text-lg tracking-tight">
                Selecciona un archivo Excel
            </h1>
            <p class="text-xs opacity-70">
                Descarga el formato de ejemplo.
                25 </p>
        </div>
    </label>
    <div class="pt-4">
        <a target="_blank" href="./template-clients.xlsx" class="text-blue-500 hover:underline">Descagar plantilla</a>
    </div>
    <div class="pt-3">
        <p class="text-xs">
            Nota: Si en el excel hay clientes que ya existen en la base de datos, se actualizarán los datos con los del
            archivo.
        </p>
    </div>
</div>
