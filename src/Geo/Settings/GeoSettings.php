<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Geo\Settings;

use FreshAdvance\ElectronicInvoice\Module;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;

class GeoSettings implements GeoSettingsInterface
{
    public const SETTING_SHOP_COUNTRY_ISO2 = 'fa_electronic_invoice_shop_country_iso';

    public function __construct(
        private readonly ModuleSettingServiceInterface $moduleSettingService,
    ) {
    }

    public function getShopCountryIso(): string
    {
        return $this->moduleSettingService->getString(
            self::SETTING_SHOP_COUNTRY_ISO2,
            Module::MODULE_ID
        )->toString();
    }
}
