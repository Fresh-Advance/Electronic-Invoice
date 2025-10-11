<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\EshopCommunity\Tests\Unit\Company\Settings;

use FreshAdvance\ElectronicInvoice\Company\Settings\CompanySettings;
use FreshAdvance\ElectronicInvoice\Company\Settings\CompanySettingsInterface;
use FreshAdvance\ElectronicInvoice\Module;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CompanySettingsTest extends TestCase
{
    #[Test]
    public function registryNoteSettingReturned(): void
    {
        $moduleSettingsServiceMock = $this->createMock(ModuleSettingServiceInterface::class);
        $moduleSettingsServiceMock->method('getCollection')
            ->with(CompanySettings::SETTING_REGISTRY_NOTE, Module::MODULE_ID)
            ->willReturn(
                $lines = [
                    uniqid(),
                    uniqid(),
                ]
            );

        $sut = $this->getSut(
            moduleSettingsService: $moduleSettingsServiceMock,
        );

        $result = $sut->getRegistryNote();
        $this->assertSame(implode("\n", $lines), $result);
    }

    private function getSut(
        ?ModuleSettingServiceInterface $moduleSettingsService = null
    ): CompanySettingsInterface {
        $moduleSettingsService ??= $this->createStub(ModuleSettingServiceInterface::class);

        return new CompanySettings(
            moduleSettingService: $moduleSettingsService,
        );
    }
}
