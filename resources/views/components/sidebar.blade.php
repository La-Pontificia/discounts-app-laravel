@php
    $items = [
        [
            'href' => '/',
            'active' => request()->is('/'),
            'icon' => 'fluentui-home-20-o',
            'active-icon' => 'fluentui-home-20',
            'text' => 'Inicio',
        ],
        [
            'href' => '/dashboard',
            'active' => request()->is('dashboard'),
            'icon' => 'fluentui-document-landscape-data-20-o',
            'active-icon' => 'fluentui-document-landscape-data-20',
            'text' => 'Dashboard',
        ],
        [
            'href' => '/users',
            'active' => request()->is('users*'),
            'icon' => 'fluentui-people-20-o',
            'active-icon' => 'fluentui-people-20',
            'text' => 'Usuarios',
        ],
        [
            'href' => '/clients',
            'active' => request()->is('clients*'),
            'icon' => 'fluentui-people-team-toolbox-20-o',
            'active-icon' => 'fluentui-people-team-toolbox-20',
            'text' => 'Clientes',
        ],
        [
            'href' => '/discounts',
            'active' => request()->is('discounts*'),
            'icon' => 'fluentui-shopping-bag-percent-20-o',
            'active-icon' => 'fluentui-shopping-bag-percent-20',
            'text' => 'Descuentos',
        ],
        [
            'href' => '/reports',
            'active' => request()->is('reports*'),
            'icon' => 'fluentui-data-histogram-20-o',
            'active-icon' => 'fluentui-data-histogram-20',
            'text' => 'Reportes',
        ],
    ];
@endphp

<aside class="bg-[#001030] p-2 space-y-1 text-sm min-w-[230px] flex flex-col text-neutral-300">
    @foreach ($items as $item)
        <a {{ $item['active'] ? 'data-active' : '' }} href="{{ $item['href'] }}"
            class="flex items-center group px-4 py-3 rounded-md hover:bg-[#35404d] transition-all data-[active]:text-white hover:text-white data-[active]:bg-[#35404d] gap-2">
            @svg($item['active'] ? $item['active-icon'] : $item['icon'], 'w-[16px] group-data-[active]:text-[#ff6c60]  group-hover:text-[#ff6c60]')
            {{ $item['text'] }}
        </a>
    @endforeach
</aside>
