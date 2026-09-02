<?php

use Contao\DC_Table;

$GLOBALS['TL_DCA']['tl_grounding_page_site'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'ptable' => 'tl_grounding_page',
        'ctable' => ['tl_grounding_page_site_element'],
        'sql' => [
            'keys' => [
                'id' => 'primary'
            ]
        ]
    ],
    'list' => [
        'sorting' => [
            'mode' => 4,
            'fields' => ['name'],
            'panelLayout' => 'filter;sort,search,limit',
            'headerFields' => ['name'],
            'child_record_callback' => function ($row) {
                return $row['name'] ?? '';
            }
        ],
        'label' => [],
        'operations' => [
            'edit',
            'children' => [
                'primary' => true,
                'href' => 'table=tl_grounding_page_site_element',
                'icon' => 'children.svg'
            ],
            'copy',
            'delete',
            'toggle',
            'show'
        ],
        'global_operations' => []
    ],
    'palettes' => [
        '__selector__' => [],
        'default' => 'name,alias'
    ],
    'subpalettes' => [],
    'fields' => [
        'id' => [
            'sql' => ['type' => 'integer', 'autoincrement' => true, 'notnull' => true, 'unsigned' => true]
        ],
        'pid' => [
            'sql' => ['type' => 'integer', 'notnull' => true, 'unsigned' => true, 'default' => 0]
        ],
        'sorting' => [
            'sql' => ['type' => 'integer', 'notnull' => true, 'unsigned' => true, 'default' => 0]
        ],
        'tstamp' => [
            'sql' => ['type' => 'integer', 'notnull' => false, 'unsigned' => true, 'default' => 0]
        ],
        'name' => [
            'inputType' => 'text',
            'eval' => [
                'maxlength' => 255,
                'tl_class' => 'w50',
                'mandatory' => true,
                'doNotCopy' => true,
                'decodeEntities' => true
            ],
            'search' => true,
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
        ],
        'alias' => [
            'inputType' => 'text',
            'eval' => [
                'maxlength' => 255,
                'tl_class' => 'w50',
                'doNotCopy' => true,
                'decodeEntities' => true
            ],
            'search' => true,
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
        ]
    ]
];