<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\ElectronicInvoice\ZUGFeRD\Service;

use FreshAdvance\Invoice\InvoiceData\DataType\InvoiceDataInterface;

interface ZugferdXmlBuilderInterface
{
    public function getXml(InvoiceDataInterface $invoiceData): string;
}
