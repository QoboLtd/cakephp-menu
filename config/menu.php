<?php
// Menu plugin configuration
return [
    'Menu' => [
        'allControllers' => true,
        'systemMenus' => [
            [
                'name' => MENU_MAIN,
                'active' => true,
                'default' => true,
                'deny_edit' => true,
                'deny_delete' => true
            ],
            [
                'name' => MENU_ADMIN,
                'active' => true,
                'default' => true,
                'deny_edit' => true,
                'deny_delete' => true
            ]
        ],
        'defaults' => [
            'url' => '#',
            'label' => 'Undefined',
            'icon' => 'cube',
            'order' => 0,
            'target' => '_self',
            'children' => [],
            'desc' => '',
        ]
    ]
];
