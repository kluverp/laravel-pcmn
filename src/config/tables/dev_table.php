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
            'placeholder' => 'input field placeholder',
            'help_text'   => 'This is a help text',
            'rules'       => ['required']
        ],
        'select_id' => [
            'type'        => 'select',
            'label'       => 'Select',
            'options'     => "Ja,1,ffffff|Nee,0,ff00ee", // if left out, source comes from DB table
            'help_text'   => 'This is a help text'
        ],
        'radio_id' => [
            'type'        => 'radio',
            'label'       => 'Radio',
            'options'     => "Ja,1,ffffff|Nee,0,ff00ee",
            'help_text'   => 'This is a help text'
        ],
        'textarea' => [
            'type'        => 'text',
            'label'       => 'Textarea',
            'help_text'   => 'This is a help text'
        ],
        /*'slug' => [
            'type'        => 'slug',
            'label'       => 'Slug'
        ],*/
        'checkboxes' => [
            'type'        => 'checkbox',
            'label'       => 'Checkboxes',
            'options'     => "Foo,1,ffffff|Nope,0,ff00ee",
            'help_text'   => 'This is a help text'
        ]
    ]
];
