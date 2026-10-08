<?php
$seoTranslateField = [
    [
        'name' => 'title',
        'label' => 'title',
        'type' => 'text',
        'require' => false
    ],
    [
        'name' => 'keywords',
        'label' => 'keywords',
        'type' => 'text',
        'require' => false
    ],
    [
        'name' => 'description',
        'label' => 'description',
        'type' => 'text',
        'require' => false
    ]
];
return [
    'product_tag' => [
        'label' => '产品关键词',
        'value' => [
            'translateField' => [
                [
                    'name' => 'name',
                    'label' => '关键词名称',
                    'type' => 'text',
                    'require' => true
                ],
            ],
            'seoTranslateField' => $seoTranslateField,
        ],
        'model' => \App\Modules\Product\Models\ProductTag::class
    ],
];
