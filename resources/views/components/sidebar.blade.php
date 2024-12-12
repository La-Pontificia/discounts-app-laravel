@php
    $items = [
        [
            'href' => '/',
            'visible' => true,
            'active' => request()->is('/'),
            'icon' => 'fluentui-home-20',
            'active-icon' => 'fluentui-home-20',
            'text' => 'Inicio',
        ],
        [
            'href' => '/dashboard',
            'visible' => true,
            'active' => request()->is('dashboard'),
            'icon' => 'fluentui-document-landscape-data-20',
            'active-icon' => 'fluentui-document-landscape-data-20',
            'text' => 'Dashboard',
        ],
        [
            'href' => '/users',
            'visible' => $authUser->role === 'admin-global',
            'active' => request()->is('users*'),
            'icon' => 'fluentui-people-20',
            'active-icon' => 'fluentui-people-20',
            'text' => 'Usuarios',
        ],
        [
            'href' => '/businesses',
            'visible' => $authUser->role !== 'business',
            'active' => request()->is('businesses*'),
            'icon' => 'fluentui-building-shop-20',
            'active-icon' => 'fluentui-building-shop-20',
            'text' => 'Empresas',
        ],
        [
            'href' => '/clients',
            'visible' => $authUser->role !== 'business',
            'active' => request()->is('clients*'),
            'icon' => 'fluentui-people-team-toolbox-20',
            'active-icon' => 'fluentui-people-team-toolbox-20',
            'text' => 'Clientes',
        ],
        [
            'href' => '/discounts',
            'visible' => true,
            'active' => request()->is('discounts*'),
            'icon' => 'fluentui-shopping-bag-percent-20',
            'active-icon' => 'fluentui-shopping-bag-percent-20',
            'text' => 'Descuentos',
        ],
        [
            'href' => '/reports',
            'visible' => true,
            'active' => request()->is('reports*'),
            'icon' => 'fluentui-data-histogram-20',
            'active-icon' => 'fluentui-data-histogram-20',
            'text' => 'Reportes',
        ],
    ];
@endphp

<aside id="sidebar"
    class="bg-[#001030] data-[open]:ml-0 ml-[-230px] transition-all p-3 space-y-1 text-xs min-w-[230px] flex flex-col text-gray-300">
    @foreach ($items as $item)
        @if (!$item['visible'])
            @continue
        @endif
        <a {{ $item['active'] ? 'data-active' : '' }} href="{{ $item['href'] }}"
            class="flex items-center group px-2 py-3 rounded-md hover:bg-[#35404d] transition-all data-[active]:text-white hover:text-white data-[active]:bg-[#35404d] gap-2">
            @svg($item['active'] ? $item['active-icon'] : $item['icon'], 'w-[20px] group-data-[active]:text-[#ff6c60]  group-hover:text-[#ff6c60]')
            {{ $item['text'] }}
        </a>
    @endforeach
</aside>
