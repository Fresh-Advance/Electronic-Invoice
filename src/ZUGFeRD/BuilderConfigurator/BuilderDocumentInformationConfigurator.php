<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator;

use DateTime;
use FreshAdvance\Invoice\DataType\InvoiceDataInterface;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\ZugferdDocumentBuilder;

class BuilderDocumentInformationConfigurator implements BuilderConfiguratorInterface
{
    public const PROCESS_ID = 'urn:zugferd:invoice:2p1:en16931';

    public function configureBuilder(
        ZugferdDocumentBuilder $builder,
        InvoiceDataInterface $invoiceData
    ): ZugferdDocumentBuilder {
        $order = $invoiceData->getOrder();
        $configuration = $invoiceData->getInvoiceConfiguration();

        /** @var object{name: string} $orderCurrency */
        $orderCurrency = $order->getOrderCurrency();

        /** @var DateTime $documentDate as getFormattedDate is created from getDate, and should be always valid */
        $documentDate = DateTime::createFromFormat($configuration->getDate(), $configuration->getFormattedDate());

        $builder->setDocumentInformation(
            $configuration->getFormattedNumber((string)$order->getFieldData('oxbillnr')),
            ZugferdInvoiceType::INVOICE,
            $documentDate,
            $orderCurrency->name,
        );

        $builder->setDocumentBusinessProcess(self::PROCESS_ID);

        return $builder;
    }
}
