<?php

namespace Alnv\ContaoGroundingPagesBundle\Helpers;

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
}