<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Tests\Unit\ZUGFeRD\BuilderConfigurator;

use FreshAdvance\ElectronicInvoice\Company\Settings\CompanySettingsInterface;
use FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator\BuilderDocumentNoteConfigurator;
use FreshAdvance\Invoice\InvoiceData\DataType\InvoiceDataInterface;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BuilderDocumentNoteConfiguratorTest extends TestCase
{
    #[Test]
    public function builderConfiguredWithDocumentInformationAndReturned(): void
    {
        $invoiceDataStub = $this->createStub(InvoiceDataInterface::class);
        $builderSpy = $this->createMock(ZugferdDocumentBuilder::class);

        $companySettingsStub = $this->createConfiguredStub(CompanySettingsInterface::class, [
            'getRegistryNote' => $registryNote = uniqid(),
        ]);

        $builderSpy->expects($this->once())
            ->method('addDocumentNote')
            ->with($registryNote, null, 'REG')
            ->willReturn($builderSpy);

        $sut = new BuilderDocumentNoteConfigurator(
            companySettings: $companySettingsStub
        );

        $result = $sut->configureBuilder($builderSpy, $invoiceDataStub);
        $this->assertSame($builderSpy, $result);
    }

    #[Test]
    public function builderNotConfiguredWithDocumentInformationIfSettingValueIsEmpty(): void
    {
        $invoiceDataStub = $this->createStub(InvoiceDataInterface::class);
        $builderSpy = $this->createMock(ZugferdDocumentBuilder::class);

        $companySettingsStub = $this->createConfiguredStub(CompanySettingsInterface::class, [
            'getRegistryNote' => '',
        ]);

        $builderSpy->expects($this->never())
            ->method('addDocumentNote');

        $sut = new BuilderDocumentNoteConfigurator(
            companySettings: $companySettingsStub
        );

        $result = $sut->configureBuilder($builderSpy, $invoiceDataStub);
        $this->assertSame($builderSpy, $result);
    }
}
