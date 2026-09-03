<?php

use Contao\Database;

$GLOBALS['TL_DCA']['tl_page']['palettes']['grounding'] = '{title_legend},title,type,alias,grounding_page;{layout_legend:hide},includeLayout;{cache_legend:hide},includeCache;{expert_legend:hide},cssClass,hide,guests,noSearch;{publish_legend},published,start,stop';

$GLOBALS['TL_DCA']['tl_page']['fields']['grounding_page'] = [
    'inputType' => 'select',
    'eval' => [
        'chosen' => true,
        'tl_class' => 'w50',
        'blankOptionLabel' => '-',
        'includeBlankOption' => true,
        'submitOnChange' => true
    ],
    'options_callback' => function () {
        $gPages = Database::getInstance()
            ->prepare('SELECT * FROM tl_grounding_page ORDER BY `name`')
            ->execute();

        $options = [];
        while ($gPages->next()) {
            $options[$gPages->id] = $gPages->name;
        }

        return $options;
    },
    'filter' => true,
    'sql' => ['type' => 'integer', 'notnull' => false, 'unsigned' => true, 'default' => 0]
];