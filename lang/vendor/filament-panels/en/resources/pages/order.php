<?php
return [
    'title' => 'Last updateds',
    'breadcrumb' => 'Last updateds',
    'actions' => [
        'create' => [
            'label' => 'Add Entry',
        ],
        'edit' => [
            'label' => 'Edit',
        ],
        'delete' => [
            'label' => 'Delete',
        ],
    ],
    'fields' => [
        'customer_name' => 'customer name',
        'status' => 'stauts',
        'order_code' => 'order code',
        'update_status' => 'Update order',
        'paid' => 'Paid completed',
        'cancel' => 'Cancel',
        'payment_method' => 'Payment method',
        'state' => [
            'pending' => 'On request',
            'paid' => 'Paid',
            'cancelled' => 'Order canceled'
        ],
        'created_at' => 'Created At',
    ],
    'view' => [
'order_details' => 'Order Details',
'item_details' => 'Details of the ordered products',
'items' => 'Products',
'product' => 'Product',
'quantity' => 'Quantity',
'price' => 'Price'
]
];
