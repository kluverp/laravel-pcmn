<?php

return [
    'title' => [
        'plural'   => 'pcmn::users.title.plural',
        'singular' => 'pcmn::users.title.singular'
    ],
    'description' => 'pcmn::users.description',
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
            'options'     => [] // if left out, source comes from DB table
        ],
        'lang' => [
            'type' => 'select',
            'label' => 'Language',
            'options'     => ['en' => 'English', 'nl' => 'Dutch'],
        ],
        'name' => [
            'type'        => 'input',
            'label'       => 'Name',
            'placeholder' => 'Name',
        ],
        'email' => [
            'type'        => 'email',
            'label'       => 'E-mail',
            'placeholder' => 'someone@example.com',
            'prepend' => '@',
            'rules' => ['required', 'email']
        ],
        'password' => [
            'type'        => 'password',
            'label'       => 'Password',
            'rules' => ['required', 'min:8', 'confirmed']
        ],
        'password_confirmation' => [
            'type'        => 'password',
            'label'       => 'Password confirmation',
        ],
    ]
];
