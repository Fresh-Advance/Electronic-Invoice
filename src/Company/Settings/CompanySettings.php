<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Company\Settings;

use FreshAdvance\ElectronicInvoice\Module;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;

class CompanySettings implements CompanySettingsInterface
{
    public const SETTING_REGISTRY_NOTE = 'fa_electronic_invoice_registry_note';

    public function __construct(
        private readonly ModuleSettingServiceInterface $moduleSettingService,
    ) {
    }

    public function getRegistryNote(): string
    {
        return implode(
            "\n",
            $this->moduleSettingService->getCollection(
                self::SETTING_REGISTRY_NOTE,
                Module::MODULE_ID
            )
        );
    }
}
