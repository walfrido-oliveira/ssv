<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title' => 'SSV',
    'title_prefix' => '::',
    'title_postfix' => '::',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    'logo' => '<b>Painel</b> SSV',
    'logo_img' => 'img/logo.jpg',
    'logo_img_class' => 'brand-image elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'SSV',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => false,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Extra Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#66-classes
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_header' => 'container-fluid',
    'classes_content' => 'container-fluid',
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand-md',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => 'register',

    'password_reset_url' => 'password/reset',

    'password_email_url' => 'password/email',

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
    |
    */

    'enabled_laravel_mix' => true,

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

    'menu' => [
        [
            'text' => 'Home',
            'url'  =>  '/',
            'topnav' => true,
            'icon' => ''
        ],
        [
            'text' => 'account_settings',
            'icon' => '',
            'can' => 'user-show-details',
            'submenu' => [
                [
                    'text' => 'profile',
                    'route' => 'profile.show',
                    'icon' => 'fas fa-fw fa-user',
                ],
                [
                    'text' => 'change_password',
                    'route' => 'profile.credentials.show',
                    'icon' => 'fas fa-fw fa-lock',
                ]
            ]
        ],
        [
            'text' => 'users',
            'icon' => 'fas fa-fw fa-user',
            'can' => 'os-list',
            'submenu' => [
                [
                    'text'  => 'user_list',
                    'route'   =>  'users.index',
                    'icon'  =>  'fas fa-fw fa-list'
                ],
                [
                    'text' => 'new',
                    'route' => 'users.create',
                    'icon' => 'fas fa-fw fa-plus',
                    'can' => 'user-create',
                ],
            ]
        ],
        [
            'text' => 'customers',
            'url' => '#',
            'icon' => 'fas fa-fw fa-users',
            'can' => 'client-list',
            'submenu' => [
                [
                    'text'  => 'customer_list',
                    'route'   =>  'clients.index',
                    'icon'  =>  'fas fa-fw fa-list'
                ],
                [
                    'text' => 'new',
                    'route' => 'clients.create',
                    'icon' => 'fas fa-fw fa-plus',
                    'can' => 'client-create',
                ],
                [
                    'text' => 'activities',
                    'url' => '#',
                    'icon' => '',
                    'submenu' => [
                        [
                            'text'  => 'activity_list',
                            'route'   =>  'activities.index',
                            'icon'  =>  'fas fa-fw fa-list'
                        ],
                        [
                            'text' => 'new',
                            'route' => 'activities.create',
                            'icon' => 'fas fa-fw fa-plus',
                            'can' => 'activity-create',
                        ],
                    ]
                ],
            ]

        ],
        [
            'text' => 'services',
            'icon' => 'fas fa-fw fa-wrench',
            'can' => 'service-list',
            'submenu' => [
                [
                    'text'  => 'service_list',
                    'route'   =>  'services.index',
                    'icon'  =>  'fas fa-fw fa-list'
                ],
                [
                    'text' => 'new',
                    'route' => 'services.create',
                    'icon' => 'fas fa-fw fa-plus',
                    'can' => 'service-create',
                ],
                [
                    'text' => 'service-types',
                    'icon' => 'fas fa-fw fa-wrench',
                    'submenu' => [
                        [
                            'text'  => 'service_type_list',
                            'route'   =>  'service-types.index',
                            'icon'  =>  'fas fa-fw fa-list'
                        ],
                        [
                            'text' => 'new',
                            'route' => 'service-types.create',
                            'icon' => 'fas fa-fw fa-plus',
                            'can' => 'service-type-create',
                        ],
                    ]
                ]
            ],
        ],
        [
            'text' => 'products',
            'icon' => 'fas fa-fw fa-archive',
            'can' => 'product-list',
            'submenu' => [
                [
                    'text'  => 'products_list',
                    'route'   =>  'products.index',
                    'icon'  =>  'fas fa-fw fa-list'
                ],
                [
                    'text' => 'new',
                    'route' => 'products.create',
                    'icon' => 'fas fa-fw fa-plus',
                    'can' => 'product-create',
                ],
                [
                    'text' => 'categories',
                    'url' => '#',
                    'icon' => '',
                    'can' => 'category-list',
                    'submenu' => [
                        [
                            'text'  => 'categories_list',
                            'route'   =>  'categories.index',
                            'icon'  =>  'fas fa-fw fa-list'
                        ],
                        [
                            'text' => 'new',
                            'route' => 'categories.create',
                            'icon' => 'fas fa-fw fa-plus',
                            'can' => 'category-create',
                        ],
                    ]
                ],
            ]
        ],
        [
            'text' => 'budgets',
            'icon' => 'fas fa-fw fa-money-check-alt',
            'can'  => ['budget-list', 'budget-show-details'],
            'submenu' => [
                [
                    'text'  => 'budgets_list',
                    'route' =>  'budgets.index',
                    'icon'  =>  'fas fa-fw fa-list'
                ],
                [
                    'text' => 'new',
                    'route' => 'budgets.create',
                    'icon' => 'fas fa-fw fa-plus',
                    'can' => 'budget-create',
                ],
                [
                    'text' => 'budget_type',
                    'url' => '#',
                    'icon' => '',
                    'can' => 'budget-type-list',
                    'submenu' => [
                        [
                            'text'  => 'budget_types_list',
                            'route'   => 'budget-types.index',
                            'icon'  => 'fas fa-fw fa-list'
                        ],
                        [
                            'text' => 'new',
                            'route' =>  'budget-types.create',
                            'icon' => 'fas fa-fw fa-plus',
                            'can' => 'budget-type-create',
                        ],
                    ]
                ],
                [
                    'text' => 'payment_methods',
                    'url' => '#',
                    'icon' => '',
                    'can' => 'payment-method-list',
                    'submenu' => [
                        [
                            'text'  => 'payment_methods_list',
                            'route'   => 'payment-methods.index',
                            'icon'  => 'fas fa-fw fa-list'
                        ],
                        [
                            'text' => 'new',
                            'route' =>  'payment-methods.create',
                            'icon' => 'fas fa-fw fa-plus',
                            'can' => 'payment-method-create',
                        ],
                    ]
                ],
                [
                    'text' => 'transport_methods',
                    'url' => '#',
                    'icon' => '',
                    'can' => 'transport-method-list',
                    'submenu' => [
                        [
                            'text'  => 'transport_methods_list',
                            'route'   => 'transport-methods.index',
                            'icon'  => 'fas fa-fw fa-list'
                        ],
                        [
                            'text' => 'new',
                            'route' =>  'transport-methods.create',
                            'icon' => 'fas fa-fw fa-plus',
                            'can' => 'transport-method-create',
                        ],
                    ]
                ],
            ]
        ],
        [
            'text' => 'service_order',
            'icon' => 'fas fa-fw fa-toolbox',
            'can' => 'os-list',
            'submenu' => [
                [
                    'text'  => 'service_list',
                    'route'   =>  'service-orders.index',
                    'icon'  =>  'fas fa-fw fa-list'
                ],
                [
                    'text' => 'new',
                    'route' => 'service-orders.create',
                    'icon' => 'fas fa-fw fa-plus',
                    'can' => 'os-create',
                ],
            ]
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        //JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        App\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        [
            'name' => 'Select2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        [
            'name' => 'Chartjs',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        [
            'name' => 'Pace',
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],
];
