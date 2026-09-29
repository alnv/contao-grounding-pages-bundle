<?php

namespace Alnv\ContaoGroundingPagesBundle\EventListener;

use Alnv\ContaoGroundingPagesBundle\Helpers\Toolkit;

class LegacySitemapListener
{

    public function getSearchablePages(array $pages, $rootId = 0, bool $isSitemap = false, string $language = null): array
    {

        $urls = Toolkit::getXmlPageUrls();
        foreach ($urls as $url) {
            $pages[] = $url;
        }

        return $pages;
    }
}