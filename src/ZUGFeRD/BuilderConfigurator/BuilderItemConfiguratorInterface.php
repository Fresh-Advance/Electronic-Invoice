<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator;

use horstoeko\zugferd\ZugferdDocumentBuilder;
use OxidEsales\Eshop\Application\Model\OrderArticle;

interface BuilderItemConfiguratorInterface
{
    public function configureOneItem(
        ZugferdDocumentBuilder $builder,
        int $position,
        OrderArticle $orderArticle,
    ): ZugferdDocumentBuilder;
}
