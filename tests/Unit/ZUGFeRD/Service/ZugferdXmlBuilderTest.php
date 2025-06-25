<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Tests\Unit\ZUGFeRD\Service;

use Codeception\PHPUnit\TestCase;
use FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator\BuilderConfiguratorInterface;
use FreshAdvance\ElectronicInvoice\ZUGFeRD\Factory\ZugferdXmlBuilderFactoryInterface;
use FreshAdvance\ElectronicInvoice\ZUGFeRD\Service\ZugferdXmlBuilder;
use FreshAdvance\Invoice\InvoiceData\DataType\InvoiceDataInterface;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use PHPUnit\Framework\Attributes\Test;

class ZugferdXmlBuilderTest extends TestCase
{
    #[Test]
    public function getXmlCallsAllConfigurationOnXmlBuilder(): void
    {
        $cleanBuilder = $this->createStub(ZugferdDocumentBuilder::class);
        $builderFactoryStub = $this->createStub(ZugferdXmlBuilderFactoryInterface::class);
        $builderFactoryStub->method('createBuilder')->willReturn($cleanBuilder);

        $inputData = $this->createStub(InvoiceDataInterface::class);
        $configuredBuilderStub = $this->createConfiguredStub(ZugferdDocumentBuilder::class, [
            'getContent' => $expectedXml = uniqid()
        ]);
        $builderConfigurator = $this->createMock(BuilderConfiguratorInterface::class);
        $builderConfigurator->method('configureBuilder')
            ->with($cleanBuilder, $inputData)
            ->willReturn($configuredBuilderStub);

        $sut = new ZugferdXmlBuilder(
            builderFactory: $builderFactoryStub,
            builderConfigurator: $builderConfigurator,
        );

        $result = $sut->getXml($inputData);
        $this->assertSame($expectedXml, $result);
    }
}
