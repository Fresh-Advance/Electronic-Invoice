<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator;

use FreshAdvance\Invoice\Pdf\Model\OrderArticleExtension;
use horstoeko\zugferd\ZugferdDocumentBuilder;

class BuilderItemConfigurator implements BuilderItemConfiguratorInterface
{
    public function configureOneItem(
        ZugferdDocumentBuilder $builder,
        int $position,
        OrderArticleExtension $orderArticle,
    ): ZugferdDocumentBuilder {
        $builder->addNewPosition((string)$position);

        $builder->setDocumentPositionProductDetails(
            name: (string)$orderArticle->getFieldData('OXTITLE'),
            sellerAssignedID: (string)$orderArticle->getFieldData('OXARTNUM')
        );

        $builder->setDocumentPositionNetPrice((float)$orderArticle->getFieldData('OXNPRICE'));

        $builder->setDocumentPositionQuantity((float)$orderArticle->getFieldData('OXAMOUNT'), "H87");

        $builder->addDocumentPositionTax(
            $orderArticle->getFieldData('OXVAT') > 0 ? 'S' : 'Z',
            'VAT',
            (float)$orderArticle->getFieldData('OXVAT')
        );

        $builder->setDocumentPositionLineSummation((float)$orderArticle->getFieldData('OXNETPRICE'));

        return $builder;
    }
}
