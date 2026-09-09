<?php

namespace Alnv\ContaoGroundingPagesBundle\Helpers;

use Contao\Database;
use Contao\StringUtil;
use PCT\CustomElements\Core\FrontendTemplate;

class GroundingPage
{
    public static function getGroundingPage($gPageId, $alias = ''): array
    {
        if (!$alias) {
            $alias = 'index';
        }

        $data = [
            'globals' => []
        ];

        $gPage = Database::getInstance()
            ->prepare('SELECT * FROM tl_grounding_page WHERE id=?')
            ->limit(1)
            ->execute($gPageId);

        $globals = StringUtil::deserialize($gPage->globals, true);

        foreach ($globals as $global) {
            if (!$global['key'] ?? '') {
                continue;
            }

            $data['globals'][$global['key']] = StringUtil::decodeEntities($global['value'] ?? '');
        }

        $gSite = Database::getInstance()
            ->prepare('SELECT * FROM tl_grounding_page_site WHERE pid=? AND alias=?')
            ->limit(1)
            ->execute($gPage->id, $alias);

        $GLOBALS['GP_GLOBALS'] = $data['globals']; // for InsertTags or SimpleTokens

        $data['title'] = Toolkit::parseString(StringUtil::deserialize($gSite->headline)['value'] ?? '');
        $data['hl'] = StringUtil::deserialize($gSite->headline)['hl'] ?? '';
        $data['structured_data'] = StringUtil::decodeEntities(Toolkit::parseSimpleTokens($gSite->structured_data ?: '', $GLOBALS['GP_GLOBALS']));
        $data['description'] = Toolkit::parseString($gSite->description);
        $data['disable_cols'] = StringUtil::deserialize($gPage->disable_cols, true);
        $data['stylesheet'] = $gPage->stylesheet ? StringUtil::binToUuid($gPage->stylesheet) : '';
        $data['elements'] = [];

        $gElements = Database::getInstance()
            ->prepare('SELECT * FROM tl_grounding_page_site_element WHERE pid=? ORDER BY sorting')
            ->execute($gSite->id);

        while ($gElements->next()) {
            $element = [];
            foreach ($gElements->row() as $field => $val) {
                if (\in_array($field, ['tstamp', 'sorting', 'pid'])) {
                    continue;
                }

                switch ($field) {
                    case 'contents':
                    case 'key_figures':
                    case 'faqs':
                    case 'headline':
                    case 'sub_headline':
                        $val = Toolkit::parseRecursive(StringUtil::deserialize($val, true));
                        break;
                    case 'anchor':
                    case 'text':
                        $val = Toolkit::parseString($val);
                        break;
                }

                $element[$field] = $val;
            }

            $data['elements'][] = $element;
        }

        return $data;
    }

    public static function parseElement($element): string
    {
        $template = new FrontendTemplate('gp_element_' . $element['type']);
        $template->setData($element);

        return $template->parse();
    }
}