<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Unit\Geo\Settings;

use FreshAdvance\ElectronicInvoice\Geo\Settings\GeoSettings;
use FreshAdvance\ElectronicInvoice\Geo\Settings\GeoSettingsInterface;
use FreshAdvance\ElectronicInvoice\Module;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\UnicodeString;

class GeoSettingsTest extends TestCase
{
    #[Test]
    public function isoFromModuleSettingsReturned(): void
    {
        $moduleSettingsResult = uniqid();

        $moduleSettingsServiceMock = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingsServiceMock->method('getString')
            ->with(GeoSettings::SETTING_SHOP_COUNTRY_ISO2, Module::MODULE_ID)
            ->willReturn(new UnicodeString($moduleSettingsResult));

        $sut = $this->getSut(
            moduleSettingsService: $moduleSettingsServiceMock,
        );

        $result = $sut->getShopCountryIso();
        $this->assertSame($moduleSettingsResult, $result);
    }

    private function getSut(
        ?ModuleSettingServiceInterface $moduleSettingsService = null
    ): GeoSettingsInterface {
        $moduleSettingsService ??= $this->createStub(ModuleSettingServiceInterface::class);

        return new GeoSettings(
            moduleSettingService: $moduleSettingsService,
        );
    }
}
