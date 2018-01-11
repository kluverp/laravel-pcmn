<?php

return [

    // homepage
    'home' => [
        'label' => 'Home',
        'icon' => '',
        'tables' => [
            'home'
        ]
    ],

    // news pages
    'news' => [
        'label' => 'News',
        'icon' => '',
        'tables' => [
            'news_news',
            'news_categories'
        ]
    ],

    // contact pages
    'contact' => [
        'label' => 'Contact',
        'icon' => '',
        'tables' => []
    ],

    // a separator
    '--' => [],

    // settings (system)
    'settings' => [
        'label' => 'Settings',
        'icon' => '&#9881;',
        'tables' => [
            'cms_settings',
            'cms_users',
            'cms_users_roles',
            'cms_languages'
        ]
    ]
];
