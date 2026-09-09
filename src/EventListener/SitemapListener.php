<?php

namespace Alnv\ContaoGroundingPagesBundle\EventListener;

use Contao\CoreBundle\Event\ContaoCoreEvents;
use Contao\CoreBundle\Event\SitemapEvent;
use Contao\Database;
use Contao\PageModel;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(ContaoCoreEvents::SITEMAP)]
class SitemapListener
{
    public function __invoke(SitemapEvent $event): void
    {
        $gPages = Database::getInstance()
            ->prepare('SELECT * FROM tl_page WHERE `type`=?')
            ->execute('grounding');

        $urls = [];
        while ($gPages->next()) {
            $glPage = PageModel::findByPk($gPages->id);

            $gPage = Database::getInstance()
                ->prepare('SELECT * FROM tl_grounding_page WHERE `id`=?')
                ->limit(1)
                ->execute($gPages->grounding_page);

            if (!$gPage->numRows) {
                continue;
            }

            $sites = Database::getInstance()
                ->prepare('SELECT * FROM tl_grounding_page_site WHERE `pid`=? ORDER BY `sorting`')
                ->execute($gPage->id);
            while ($sites->next()) {
                $alias = $sites->alias;
                if ($alias == 'index') {
                    $alias = '';
                }

                try {
                    $url = $glPage->getAbsoluteUrl($alias ? '/' . $alias : '');
                } catch (\Exception $e) {
                    continue;
                }

                if (!\in_array($url, $urls)) {
                    $event->addUrlToDefaultUrlSet($url);
                }

                $urls[] = $url;
            }
        }
    }
}