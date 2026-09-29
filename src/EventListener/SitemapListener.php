<?php

namespace Alnv\ContaoGroundingPagesBundle\EventListener;

use Alnv\ContaoGroundingPagesBundle\Helpers\Toolkit;
use Contao\CoreBundle\Event\SitemapEvent;
use Contao\Database;
use Contao\PageModel;

class SitemapListener
{
    public function __invoke(SitemapEvent $event): void
    {
        if (!\method_exists($event, 'addUrlToDefaultUrlSet')) {
            return;
        }

        $urls = Toolkit::getXmlPageUrls();
        foreach ($urls as $url) {
            $event->addUrlToDefaultUrlSet($url);
        }
    }
}