<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sidebar configuration
    |--------------------------------------------------------------------------
    |
    | Use this configuration format for a static sidebar menu by adding or
    | removing items. This config is loaded from
    | Http\ViewComposers\SidebarViewComposer.php
    | In that file you can change how to get the sidebar menu configuration,
    | instead of using a static file, you can use a Model to obtain the
    | menu items dinamically from database applying own business logic.
    |
    */
    [
        'text' => 'Menu Utama',
        'heading' => true,
        'translate' => 'sidebar.heading.HEADER'
    ],
    [
        'role' => '1',
        'text' => 'Dashboard',
        'route' => 'admin/dashboard',
        'icon' => 'icon-speedometer',
        'alert' => '3'
    ],
    [
        'text' => 'Master',
        'heading' => true,
        'translate' => 'sidebar.heading.HEADER'
    ],
    [
        'role' => '1',
        'text' => 'Paket',
        'route' => 'admin/paket',
        'icon' => 'fas fa-shopping-bag',
        'alert' => '30'
    ],
    [
        'role' => '1',
        'text' => 'Lapang',
        'route' => 'admin/lapang',
        'icon' => 'fas fa-flag-checkered',
        'alert' => '30'
    ],
    [
        'role' => '1',
        'text' => 'Kategori',
        'route' => 'admin/kategori',
        'icon' => 'fas fa-copy',
        'alert' => '30'
    ],
    [
        'text' => 'Order',
        'heading' => true,
        'translate' => 'sidebar.heading.HEADER'
    ],
    [
        'role' => '1',
        'text' => 'Booking',
        'route' => 'admin/booking',
        'icon' => 'fas fa-handshake',
        'alert' => '30'
    ],
    [
        'role' => '1',
        'text' => 'Member',
        'route' => 'admin/member',
        'icon' => 'fas fa-id-badge',
        'alert' => '30'
    ],
    [
        'role' => '1',
        'text' => 'Pelatihan',
        'route' => 'admin/diklat',
        'icon' => 'fas fa-walking',
        'alert' => '30'
    ],
    [
        'text' => 'Pengaturan',
        'heading' => true,
        'translate' => 'sidebar.heading.HEADER'
    ],
    [
        'role' => '1',
        'text' => 'Laporan',
        'route' => 'admin/laporan',
        'icon' => 'fas fa-print',
        'alert' => '30'
    ]
];
