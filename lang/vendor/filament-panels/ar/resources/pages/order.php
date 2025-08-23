<?php
return [
    'title' => '  الطلبات',
    'breadcrumb' => '  الطلبات',
    'actions' => [
        'create' => [
            'label' => 'إضافة الطلبات',
        ],
        'edit' => [
            'label' => 'تعديل',
        ],
        'delete' => [
            'label' => 'حذف',
        ],
    ],
    'fields' => [
        'customer_name' => 'اسم العميل',
        'status' => 'الحالة',
        'order_code' => 'كود الطلب',
        'update_status' => 'تحديث الطلب',
        'paid' => 'تم الدفع',
        'cancel' => 'الغاء',
        'payment_method' => 'طريقة الدفع',
        'state' => [
            'pending' => 'تحت الطلب',
            'paid' => 'تم الدفع',
            'cancelled' => 'تم الغاء الطلب'
        ],
        'created_at' => 'تاريخ الإنشاء',
    ],
    'view' => [
        'order_details' => 'تفاصيل الطلب',
        'item_details' => 'تفاصيل المنتجات المطلوبة',
        'items' => 'المنتجات',
        'product' => 'المنتج',
        'quantity' => 'الكمية',
        'price' => 'السعر'
    ]
];