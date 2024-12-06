<nav class="flex items-center gap-2 border-b p-2 bg-white shadow-md">
    <div class="flex-grow px-3">
        <a class="w-fit" href="#">
            <img src="/elp.webp" style="width: 100px; height: auto;" alt="">
        </a>
    </div>
    <nav class="flex px-5 gap-4 items-center">
        <div class="pr-2 text-sm border border-neutral-500/20 p-2 py-1 rounded-xl bg-stone-500/10">
            <h2 class="font-semibold">
                {{ $authUser->displayName() }}
            </h2>
            <span
                class="bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
                @svg('fluentui-person-20', 'w-4 h-4')
                {{ $authUser->roleDisplayName() }}
            </span>
        </div>
        <div>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                class="flex-none flex gap-1 items-center font-medium hover:underline">
                @svg('fluentui-sign-out-24-o', 'w-6 h-6')
                Salir
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </nav>
</nav>
