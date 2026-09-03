<?php

namespace Alnv\ContaoGroundingPagesBundle\EventListener;

use Alnv\ContaoGroundingPagesBundle\Helpers\GroundingPage;
use Contao\Input;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;
use Contao\StringUtil;

class GetPageLayoutListener
{
    public function __invoke(PageModel $page, LayoutModel &$layout, PageRegular $pageRegular): void
    {
        if ($page->type !== 'grounding' || !$page->grounding_page) {
            return;
        }

        $gSite = GroundingPage::getGroundingPage($page->grounding_page, Input::xssClean($_GET['auto_item'] ?? ''));

        $layout->titleTag = '{{page::pageTitle}}';
        $layout->viewport = 'width=device-width, initial-scale=1';

        $modules = [];
        foreach (StringUtil::deserialize($layout->modules, true) as $module) {
            if (\in_array($module['col'], $gSite['disable_cols'])) {
                continue;
            }

            $modules[] = $module;
        }

        $layout->modules = \serialize($modules);
    }
}