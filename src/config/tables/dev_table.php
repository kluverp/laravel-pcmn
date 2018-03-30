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
        'order' => ['presenter' => function($value) {
            return '<span class="badge badge-info">' . $value .  '</span>';
        }],
        'active' => ['sortable' => true, 'searchable' => false, 'presenter' => 'boolean'],
        'slug' => ['sortable' => true, 'searchable' => true],
        'select_id' => [],
        'textarea' => ['sortable' => true, 'searchable' => true, 'presenter' => 'text']
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
            'label' => 'ID'
        ],
        'active' => [
            'type' => 'boolean',
            'label' => 'Active',
            'help_text' => 'Item is published yes or no.'
        ],
        'order' => [
            'type' => 'text',
            'label' => 'Order'
        ],
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
            'options'     => ['Ja', 'Nee'],
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
