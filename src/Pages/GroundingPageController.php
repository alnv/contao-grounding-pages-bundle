<?php

namespace Alnv\ContaoGroundingPagesBundle\Pages;

use Contao\FrontendIndex;
use Contao\Input;
use Contao\PageModel;
use Alnv\ContaoGroundingPagesBundle\Helpers\GroundingPage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GroundingPageController
{
    public function __invoke(Request $request, PageModel $pageModel): Response
    {

        $pageModel->robots = 'index,follow';
        $pageModel->canonicalLink = $pageModel->getAbsoluteUrl(); // todo  add url
        $pageModel->canonicalKeepParams = '';

        $gSite = GroundingPage::getGroundingPage($pageModel->grounding_page, Input::xssClean($_GET['auto_item'] ?? ''));

        $pageModel->title = $gSite['title'];
        $pageModel->pageTitle = $gSite['title'];
        $pageModel->description = $gSite['description'] ?? '';

        return (new FrontendIndex())->renderPage($pageModel);
    }

}