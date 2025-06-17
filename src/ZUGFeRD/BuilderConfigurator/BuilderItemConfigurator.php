<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator;

use FreshAdvance\ElectronicInvoice\Order\Service\OrderArticlePriceAdjustInterface;
use FreshAdvance\Invoice\DataType\InvoiceDataInterface;
use FreshAdvance\Invoice\Pdf\Model\OrderArticleExtension;
use horstoeko\zugferd\ZugferdDocumentBuilder;

class BuilderItemConfigurator implements BuilderItemConfiguratorInterface
{
    public function __construct(
        private readonly OrderArticlePriceAdjustInterface $orderArticlePriceAdjust,
    ) {
    }

    public function configureOneItem(
        ZugferdDocumentBuilder $builder,
        InvoiceDataInterface $invoiceData,
        int $position,
        OrderArticleExtension $orderArticle,
    ): ZugferdDocumentBuilder {
        $builder->addNewPosition((string)$position);

        $builder->setDocumentPositionProductDetails(
            name: $orderArticle->faGetTranslatedTitle($invoiceData->getLanguageId()),
            sellerAssignedID: (string)$orderArticle->getFieldData('OXARTNUM')
        );

        $builder->setDocumentPositionNetPrice(
            $this->orderArticlePriceAdjust->adjustNetValueByOrder(
                (float)$orderArticle->getFieldData('OXNPRICE'),
                $invoiceData->getOrder(),
            )
        );

        $builder->setDocumentPositionQuantity((float)$orderArticle->getFieldData('OXAMOUNT'), "H87");

        $builder->addDocumentPositionTax(
            $orderArticle->getFieldData('OXVAT') > 0 ? 'S' : 'Z',
            'VAT',
            (float)$orderArticle->getFieldData('OXVAT')
        );

        $builder->setDocumentPositionLineSummation(
            $this->orderArticlePriceAdjust->adjustNetValueByOrder(
                (float)$orderArticle->getFieldData('OXNETPRICE'),
                $invoiceData->getOrder(),
            )
        );

        return $builder;
    }
}
