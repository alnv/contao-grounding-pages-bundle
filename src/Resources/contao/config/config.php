<?php

use Contao\ArrayUtil;

ArrayUtil::arrayInsert($GLOBALS['BE_MOD'], 1, [
    'grounding_page_bundle' => [
        'grounding_page' => [
            'name' => 'grounding_page',
            'tables' => [
                'tl_grounding_page',
                'tl_grounding_page_site',
                'tl_grounding_page_site_element'
            ]
        ]
    ]
]);