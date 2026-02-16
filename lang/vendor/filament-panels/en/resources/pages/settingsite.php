<?php
return [
    'title' => 'setting site',
    'breadcrumb' => 'setting site',
    'actions' => [
        'create' => [
            'label' => 'Add setting site',
        ],
        'edit' => [
            'label' => 'Edit',
        ],
        'delete' => [
            'label' => 'Delete',
        ],
    ],
    'fields' => [
        'shop_link' => 'store address',
        'contact_us' => 'contact link',
        'aboutus' => 'About Us',
        'map_link' => 'site map',
        'whats_app' => 'whats_app number',
        'created_at' => 'Created At',
    ],

    'success' => 'Successfully updated',
    'tabs' => [
        'sitesetting' => 'Footer Content',
        'whats_app_email' => 'Contact Numbers and Email',
        'about_us' => 'About Us'
    ]
];
