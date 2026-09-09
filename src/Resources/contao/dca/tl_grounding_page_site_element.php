<?php

use Contao\DC_Table;

$GLOBALS['TL_DCA']['tl_grounding_page_site_element'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'ptable' => 'tl_grounding_page_site',
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
            'edit' => [
                'primary' => true,
                'href' => 'act=edit',
                'icon' => 'edit.svg'
            ],
            'delete' => [
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? '') . '\'))return false;Backend.getScrollOffset()"'
            ],
            'toggle' => [
                'href' => 'act=toggle&amp;field=published',
                'icon' => 'visible.svg',
                'showInHeader' => true
            ],
            'show' => [
                'href' => 'act=show',
                'icon' => 'show.svg'
            ]
        ],
        'global_operations' => []
    ],
    'palettes' => [
        '__selector__' => ['type'],
        'default' => 'type',
        'key_figures' => 'type,name,anchor;headline,sub_headline,text;key_figures',
        'faq' => 'type,name,anchor;headline,sub_headline,text;faqs',
        'content' => 'type,name,anchor;headline,sub_headline,text;contents',
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
        'type' => [
            'inputType' => 'select',
            'eval' => [
                'tl_class' => 'w50',
                'submitOnChange' => true,
                'includeBlankOption' => true
            ],
            'reference' => &$GLOBALS['TL_LANG']['tl_suite_modules']['types'],
            'options_callback' => function () {
                return [
                    'key_figures' => 'Kerndaten',
                    'faq' => 'FAQ',
                    'content' => 'Text'
                ];
            },
            'sql' => ['type' => 'string', 'length' => 128, 'default' => '']
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
        'anchor' => [
            'inputType' => 'text',
            'eval' => [
                'maxlength' => 255,
                'tl_class' => 'w50',
                'doNotCopy' => true,
                'decodeEntities' => true
            ],
            'filter' => true,
            'sql' => ['type' => 'string', 'length' => 255, 'default' => '']
        ],
        'headline' => [
            'inputType' => 'inputUnit',
            'options' => ['h2', 'h1', 'h3', 'h4', 'h5', 'h6'],
            'eval' => [
                'tl_class' => 'w50',
                'allowHtml' => true
            ],
            'sql' => "text NULL"
        ],
        'sub_headline' => [
            'inputType' => 'inputUnit',
            'options' => ['h3', 'h1', 'h2', 'h4', 'h5', 'h6'],
            'eval' => [
                'tl_class' => 'w50',
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
        'key_figures' => [
            'inputType' => 'multiColumnWizard',
            'eval' => [
                'decodeEntities' => true,
                'tl_class' => 'clr',
                'columnFields' => [
                    'key' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_grounding_page_site_element']['key'],
                        'inputType' => 'text',
                        'eval' => ['style' => 'width:100%']
                    ],
                    'fact' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_grounding_page_site_element']['fact'],
                        'inputType' => 'text',
                        'eval' => ['style' => 'width:100%']
                    ]
                ]
            ],
            'sql' => 'blob NULL'
        ],
        'faqs' => [
            'inputType' => 'multiColumnWizard',
            'eval' => [
                'decodeEntities' => true,
                'tl_class' => 'clr',
                'columnFields' => [
                    'question' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_grounding_page_site_element']['question'],
                        'inputType' => 'inputUnit',
                        'options' => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
                        'eval' => ['style' => 'width:100%']
                    ],
                    'answer' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_grounding_page_site_element']['answer'],
                        'inputType' => 'textarea',
                        'eval' => ['style' => 'width:100%']
                    ]
                ]
            ],
            'sql' => 'blob NULL'
        ],
        'contents' => [
            'inputType' => 'group',
            'palette' => ['headline', 'text'],
            'fields' => [
                'headline' => [
                    'label' => &$GLOBALS['TL_LANG']['tl_grounding_page_site_element']['headline'],
                    'inputType' => 'inputUnit',
                    'options' => ['h3', 'h1', 'h2', 'h4', 'h5', 'h6'],
                    'eval' => [
                        'tl_class' => 'w50'
                    ]
                ],
                'text' => [
                    'label' => &$GLOBALS['TL_LANG']['tl_grounding_page_site_element']['text'],
                    'inputType' => 'textarea',
                    'eval' => [
                        'rte' => 'tinyMCE',
                        'allowHtml' => true,
                        'tl_class' => 'clr'
                    ]
                ]
            ],
            'min' => 1,
            'order' => true,
            'sql' => 'blob NULL'
        ]
    ]
];