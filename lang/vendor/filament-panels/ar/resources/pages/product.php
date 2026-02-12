<?php
return [
    'title' => 'المنتجات',
    'breadcrumb' => 'المنتجات',
    'actions' => [
        'create' => [
            'label' => 'إضافة منتج',
        ],
        'edit' => [
            'label' => 'تعديل',
        ],
        'delete' => [
            'label' => 'حذف',
        ],
    ],
    'fields' => [
        'header' => 'انشاء منتج',
        'description' => 'مواصفات المنتج',
        'subcategory_id' => 'قائمة المتجات الفرعية التي يتم ربطها بالمنتج',
        'category_id' => 'قائمة المتجات الرئيسية التي يتم ربطها بالمنتج',
        'title' => 'اسم المنتج',
        'optiontitle' => 'اسم الوحدة',
        'product_code' => 'كود المنتج',
        'generatecode' => 'انشاء كود دينامك',
        'available' => 'هل المنتج متوفر ام غير متوفر',
        'rate' => 'تقيم',
        'state' => 'الحالة',
        'content' => 'المحتوي',
        'price' => 'السعر',
        'main_image' => 'الصورة الرئيسية',
        'images' => 'صور المنتج',
        'state_product' =>[
            'new' => 'جديد',
            'special' => 'مميز',
            'top' => 'الاكثر مبيعا',
            'kids' => 'خاص بالاطفال',
        ],
        'product_option' => 'اصناف المنتج',
        'product_option_des' => 'تحديد وحدات المنتج من كمية و اضافة اسعار',
        'product_option_make' => 'اضافة وحدة للمنتج مثل كرتون , علبة مع تحديد سعر كل وحدة متاحة',
        'add_option' => 'اضف اخر',
        'created_at' => 'تاريخ الإنشاء',
    ],

];