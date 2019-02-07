<?php

return [
    'title' => [
        'plural' => 'pcmn::users.title.plural',
        'singular' => 'pcmn::users.title.singular'
    ],
    'description' => 'pcmn::users.description',
    'permissions' => [
        'create' => true,
        'read' => true,
        'update' => true,
        'delete' => true,
    ],
    'index' => [
        'name' => ['sortable' => true, 'searchable' => true],
        'email' => ['sortable' => true, 'searchable' => true]
    ],
    'form' => [
        'active' => [
            'type' => 'radio',
            'label' => 'pcmn::users.form.active',
            'options' => 'active,name,id' // if left out, source comes from DB table
        ],
        'lang' => [
            'type' => 'select',
            'label' => 'pcmn::users.form.lang',
            'options' => ['en' => 'EN', 'nl' => 'NL'],
        ],
        'name' => [
            'type' => 'input',
            'label' => 'pcmn::users.form.name',
            'placeholder' => 'Name',
        ],
        'email' => [
            'type' => 'email',
            'label' => 'pcmn::users.form.email',
            'placeholder' => 'someone@example.com',
            'prepend' => '@',
            'rules' => ['required', 'email']
        ],
        'password' => [
            'type' => 'password',
            'label' => 'pcmn::users.form.password',
            'rules' => ['required', 'min:8', 'confirmed']
        ],
        'password_confirmation' => [
            'type' => 'password',
            'label' => 'pcmn::users.form.password_confirmation',
        ],
    ]
];
