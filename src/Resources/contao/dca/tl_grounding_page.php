<?php

use Contao\DC_Table;
use Contao\Database;
use Contao\StringUtil;

$GLOBALS['TL_DCA']['tl_grounding_page'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'ctable' => ['tl_grounding_page_site'],
        'sql' => [
            'keys' => [
                'id' => 'primary'
            ]
        ]
    ],
    'list' => [
        'sorting' => [
            'mode' => 0,
            'fields' => ['name']
        ],
        'label' => [
            'fields' => ['name'],
            'showColumns' => true
        ],
        'operations' => [
            'edit' => [
                'primary' => true,
                'href' => 'act=edit',
                'icon' => 'edit.svg'
            ],
            'children' => [
                'primary' => true,
                'href' => 'table=tl_grounding_page_site',
                'icon' => 'children.svg'
            ],
            'delete' => [
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? '') . '\'))return false;Backend.getScrollOffset()"'
            ],
            'show' => [
                'href' => 'act=show',
                'icon' => 'show.svg'
            ]
        ],
        'global_operations' => []
    ],
    'palettes' => [
        'default' => 'name,alias;globals;disable_cols,stylesheet'
    ],
    'fields' => [
        'id' => [
            'sql' => ['type' => 'integer', 'autoincrement' => true, 'notnull' => true, 'unsigned' => true]
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
        'disable_cols' => [
            'inputType' => 'select',
            'eval' => [
                'chosen' => true,
                'multiple' => true,
                'tl_class' => 'long clr',
            ],
            'options_callback' => function () {
                $layouts = Database::getInstance()
                    ->prepare('SELECT * FROM tl_layout')
                    ->execute();

                $cols = [];
                while ($layouts->next()) {
                    $modules = StringUtil::deserialize($layouts->modules, true);
                    foreach ($modules as $module) {
                        $cols[$module['col']] = $module['col'];
                    }
                }

                return $cols;
            },
            'sql' => 'blob NULL'
        ],
        'globals' => [
            'inputType' => 'multiColumnWizard',
            'eval' => [
                'decodeEntities' => true,
                'tl_class' => 'clr',
                'columnFields' => [
                    'key' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_grounding_page']['key'],
                        'inputType' => 'text',
                        'eval' => ['style' => 'width:100%']
                    ],
                    'value' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_grounding_page']['value'],
                        'inputType' => 'text',
                        'eval' => ['style' => 'width:100%']
                    ]
                ]
            ],
            'sql' => 'blob NULL'
        ],
        'stylesheet' => [
            'inputType' => 'fileTree',
            'eval' => [
                'filesOnly' => true,
                'extensions' => 'scss',
                'fieldType' => 'radio',
                'tl_class' => 'clr'
            ],
            'sql' => 'blob NULL'
        ],
    ]
];