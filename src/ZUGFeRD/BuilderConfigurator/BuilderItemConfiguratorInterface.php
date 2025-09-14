<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator;

use FreshAdvance\Invoice\InvoiceData\DataType\InvoiceDataInterface;
use FreshAdvance\Invoice\Pdf\Model\OrderArticleExtension;
use horstoeko\zugferd\ZugferdDocumentBuilder;

interface BuilderItemConfiguratorInterface
{
    public function configureOneItem(
        ZugferdDocumentBuilder $builder,
        int $position,
        OrderArticleExtension $orderArticle,
    ): ZugferdDocumentBuilder;
}
