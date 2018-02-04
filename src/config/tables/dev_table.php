<?php

return [
    'title' => [
        'plural'   => 'Test',
        'singular' => 'Test'
    ],
    'description' => 'Curabitur aliquet quam id dui posuere blandit.',
    'permissions' => [
        'create' => true,
        'read'   => true,
        'update' => true,
        'delete' => true,
    ],
    'index' => [
        'id' => ['sortable' => true, 'searchable' => true],
        'slug' => ['sortable' => true, 'searchable' => true]
    ],
    'fields' => [
        'input' => [
            'type'        => 'input',
            'label'       => 'Input',
            'placeholder' => 'input field placeholder'
        ],
        'select_id' => [
            'type'        => 'select',
            'label'       => 'Select',
            'options'     => "Ja,1,ffffff|Nee,0,ff00ee" // if left out, source comes from DB table
        ],
        'radio_id' => [
            'type'        => 'radio',
            'label'       => 'Radio',
            'options'     => "Ja,1,ffffff|Nee,0,ff00ee"
        ],
        'textarea' => [
            'type'        => 'text',
            'label'       => 'Textarea'
        ],
        /*'slug' => [
            'type'        => 'slug',
            'label'       => 'Slug'
        ],
        'checkboxes' => [
            'type'        => 'checkbox',
            'label'       => 'Checkboxes'
        ]*/
    ]
];
