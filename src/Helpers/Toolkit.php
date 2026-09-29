<?php

namespace Alnv\ContaoGroundingPagesBundle\Helpers;

use Contao\Database;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;

class Toolkit
{
    public static function parseString($text): string
    {
        $text = \trim($text);
        $text = StringUtil::decodeEntities($text);
        $text = strip_tags($text, '<section><h1><h2><h3><p><a><ul><ol><li><dl><dt><dd><table><thead><tbody><tr><th><td><blockquote><small>');
        $text = self::parseSimpleTokens($text, $GLOBALS['GP_GLOBALS']);

        return self::replaceInsertTags($text);
    }

    public static function parseRecursive(mixed $value): mixed
    {
        if (\is_array($value)) {
            $result = [];

            foreach ($value as $key => $item) {
                $key = self::parseRecursive($key);
                $result[$key] = self::parseRecursive($item);
            }

            return $result;
        }

        if (\is_string($value)) {
            return self::parseString($value);
        }

        return $value;
    }

    public static function parseSimpleTokens($strString, $arrData, $blnAllowHtml = true)
    {
        $strString = StringUtil::decodeEntities($strString);
        
        return System::getContainer()
            ->get('contao.string.simple_token_parser')
            ->parse($strString, $arrData, $blnAllowHtml);
    }

    public static function replaceInsertTags($strBuffer, $blnCache = true)
    {

        $parser = System::getContainer()->get('contao.insert_tag.parser');

        if ($blnCache) {
            return $parser->replace((string)$strBuffer);
        }

        return $parser->replaceInline((string)$strBuffer);
    }

    public static function getXmlPageUrls(): array
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
                    $url = $glPage->getAbsoluteUrl('/' . $alias);
                } catch (\Exception $e) {
                    continue;
                }

                $urls[] = $url;
            }
        }

        return \array_values(\array_unique($urls));
    }
}