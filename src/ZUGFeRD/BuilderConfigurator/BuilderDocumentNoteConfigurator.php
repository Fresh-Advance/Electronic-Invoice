<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator;

use FreshAdvance\ElectronicInvoice\Company\Settings\CompanySettingsInterface;
use FreshAdvance\Invoice\InvoiceData\DataType\InvoiceDataInterface;
use horstoeko\zugferd\ZugferdDocumentBuilder;

class BuilderDocumentNoteConfigurator implements BuilderConfiguratorInterface
{
    public function __construct(
        private readonly CompanySettingsInterface $companySettings,
    ) {
    }

    public function configureBuilder(
        ZugferdDocumentBuilder $builder,
        InvoiceDataInterface $invoiceData
    ): ZugferdDocumentBuilder {
        if ($note = $this->companySettings->getRegistryNote()) {
            $builder->addDocumentNote($note, null, 'REG');
        }

        return $builder;
    }
}
