<?php

namespace Alnv\ContaoGroundingPagesBundle\InsertTags;

use Alnv\ContaoCatalogManagerBundle\Helper\Mode;
use Alnv\ContaoCatalogManagerBundle\Helper\ModelWizard;
use Alnv\ContaoCatalogManagerBundle\Helper\Toolkit;
use Contao\Database;
use Contao\Date;
use Contao\StringUtil;
use Contao\System;
use Contao\Config;
use Contao\Validator;

class GlobalsInertTag
{
    public function __invoke($insertTag)
    {
        $fragments = \explode('::', $insertTag);

        if (\strtolower($fragments[0] ?? '') == 'gp_global') {
            return ''; // todo
        }

        return false;
    }
}