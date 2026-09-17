<?php

namespace Alnv\ContaoGroundingPagesBundle\EventListener;

use Alnv\ContaoGroundingPagesBundle\Helpers\GroundingPage;
use Contao\Input;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;
use PCT\CustomElements\Core\FrontendTemplate;

class GeneratePageListener
{

    public function __invoke(PageModel $page, LayoutModel $layout, PageRegular &$pageRegular): void
    {
        if ($page->type !== 'grounding' || !$page->grounding_page) {
            return;
        }

        $gSite = GroundingPage::getGroundingPage($page->grounding_page, Input::xssClean($_GET['auto_item'] ?? ''));

        $main = '';
        foreach ($gSite['elements'] as $element) {
            $main .= GroundingPage::parseElement($element);
        }

        $template = new FrontendTemplate('gp_main_section');
        $template->main = $main;

        foreach ($gSite as $key => $val) {
            $template->{$key} = $val;
        }
        $template->lastModified = ($gSite['lastModified'] ?? 0) ? \date('d.m.Y', $gSite['lastModified']) : '';

        $pageRegular->Template->main = $template->parse();

        try {
            $canonicalUrl = $page->getAbsoluteUrl($gSite['alias'] ? ('/' . $gSite['alias']) : '');
            $GLOBALS['TL_HEAD']['canonical'] = '<link rel="canonical" href="' . $canonicalUrl . '">';
        } catch (\Exception $e) {
        }
    }
}