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
            'fields' => ['sorting'],
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
        'default' => 'name,alias;headline,description,text;structured_data'
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
        ],
        'headline' => [
            'inputType' => 'inputUnit',
            'options' => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
            'eval' => [
                'tl_class' => 'w50',
                'allowHtml' => true
            ],
            'sql' => "text NULL"
        ],
        'description' => [
            'inputType' => 'textarea',
            'eval' => [
                'tl_class' => 'clr',
                'allowHtml' => true
            ],
            'sql' => "text NULL"
        ],
        'text' => [
            'inputType' => 'textarea',
            'eval' => [
                'tl_class' => 'clr',
                'rte' => 'tinyMCE',
                'allowHtml' => true
            ],
            'sql' => "text NULL"
        ],
        'structured_data' => [
            'inputType' => 'textarea',
            'eval' => [
                'allowHtml' => true,
                'class' => 'monospace',
                'rte' => 'ace|html'
            ],
            'sql' => 'mediumtext NULL'
        ]
    ]
];