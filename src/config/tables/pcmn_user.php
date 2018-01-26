<?php

/*
|--------------------------------------------------------------------------
| Main CMS Configuration
|--------------------------------------------------------------------------
|
| This is the form configuration file
| This file defines the tables config in
| the following way:
|
| <fieldname>[type]			Field type (input|text|radio|select|checkbox|editor|file|image|slug)
| <fieldname>[label]		Label next to field
| <fieldname>[placeholder]	Optional placeholder
| <fieldname>[list]			Show the column in list yes/no
|
*/

return [
    'title' => [
        'plural'   => 'Users',
        'singular' => 'User'
    ],
    'description' => 'Manage the users that have access to the system.',
    'permissions' => [
        'create' => true,
        'read'   => true,
        'update' => true,
        'delete' => true,
    ],
    'index' => [
        'name' => ['sortable' => true, 'searchable' => true],
        'email' => ['sortable' => true, 'searchable' => true]
    ],
    'fields' => [
        'status' => [
            'type'        => 'radio',
            'label'       => 'Status',
            'options'     => "Ja,1,ffffff|Nee,0,ff00ee" // if left out, source comes from DB table
        ],
        'name' => [
            'type'        => 'input',
            'label'       => 'Name',
            'placeholder' => 'Name',

        ],
        'email' => [
            'type'        => 'email',
            'label'       => 'E-mail',
            'placeholder' => 'someone@example.com'
        ]
    ]
];
