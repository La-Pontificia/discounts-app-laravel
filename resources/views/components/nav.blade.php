<nav class="flex items-center gap-2 border-b p-2 bg-white">
    <div class="flex-grow px-3 flex items-center gap-3">
        <button id="sidebar-toggle" class="pr-2">
            @svg('fluentui-line-horizontal-3-20', 'w-6 h-6')
        </button>
        <a class="w-fit" href="#">
            <img src="/lp.webp" style="width: 120px; height: auto;" alt="">
        </a>
    </div>
    <nav class="flex gap-4 items-center">
        <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation"
            class="border bg-white-700 hover:bg-white-800 rounded-md text-sm px-5 py-2.5 text-center inline-flex items-center"
            type="button"> {{ $authUser->displayName() }} <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg>
        </button>
        <div id="dropdownInformation"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
            <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                <div>{{ $authUser->displayName() }}</div>
                <div class="font-medium truncate">{{ $authUser->roleDisplayName() }}</div>
            </div>
            <div class="py-2">

                <button data-modal-target="dialog-change-password" data-modal-toggle="dialog-change-password"
                    class="flex items-center gap-2 text-left text-nowrap px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                    Cambiar contraseña
                </button>


                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                    Cerrar sesión
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>
</nav>


<div id="dialog-change-password" tabindex="-1" aria-hidden="true" class="dialog hidden">
    <div class="content lg:max-w-lg max-w-full">
        <header>
            Actualizar contraseña: {{ $authUser->displayName() }}
        </header>
        <form action="/auth/change-password" method="POST" id="dialog-form-change-password"
            class="dinamic-form body grid gap-4 pb-5">
            <label class="label">
                <span>Contraseña actual.</span>
                <input type="password" name="oldPassword" required>
            </label>
            <label class="label">
                <span>Nueva contraseña.</span>
                <input type="password" name="newPassword" required>
            </label>
            <label class="label">
                <span>Confirmar contraseña.</span>
                <input type="password" name="confirmPassword" required>
            </label>
        </form>
        <footer>
            <button data-modal-hide="dialog-change-password" type="button">Cancelar</button>
            <button form="dialog-form-change-password" type="submit">
                Actualizar contraseña</button>
        </footer>
    </div>
</div>
