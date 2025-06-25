<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Tests\Unit\ZUGFeRD\BuilderConfigurator;

use FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator\BuilderDocumentInformationConfigurator;
use FreshAdvance\Invoice\InvoiceData\DataType\InvoiceDataInterface;
use FreshAdvance\Invoice\InvoiceData\InvoiceConfiguration\DataType\InvoiceConfigurationInterface;
use FreshAdvance\Invoice\Pdf\Service\FormatCalculatorInterface;
use horstoeko\zugferd\codelists\ZugferdInvoiceType;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use OxidEsales\Eshop\Application\Model\Order;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use stdClass;

class BuilderDocumentInformationConfiguratorTest extends TestCase
{
    #[Test]
    public function builderConfiguredWithDocumentInformationAndReturned(): void
    {
        $currencyStub = new stdClass();
        $currencyStub->name = $currencyName = uniqid();

        $orderStub = $this->createMock(Order::class);
        $orderStub->method('getFieldData')->willReturnMap([
            ['oxbillnr', $billNr = rand(1, 100)],
        ]);
        $orderStub->method('getOrderCurrency')
            ->willReturn($currencyStub);

        $dateFormat = date('123');
        $invoiceConfigurationMock = $this->createMock(InvoiceConfigurationInterface::class);
        $invoiceConfigurationMock->method('getDate')
            ->willReturn($dateFormat);
        $invoiceConfigurationMock->method('getFormattedDate')
            ->willReturn($date = date($dateFormat));
        $invoiceConfigurationMock->method('getNumber')
            ->willReturn($numberFormat = uniqid());

        $invoiceDataStub = $this->createConfiguredStub(InvoiceDataInterface::class, [
            'getOrder' => $orderStub,
            'getInvoiceConfiguration' => $invoiceConfigurationMock
        ]);

        $formatCalculator = $this->createMock(FormatCalculatorInterface::class);
        $formatCalculator->method('calculateByFormat')
            ->with($numberFormat, $invoiceDataStub)
            ->willReturn($formattedNumber = uniqid());

        $builderSpy = $this->createMock(ZugferdDocumentBuilder::class);
        $builderSpy->expects($this->once())
            ->method('setDocumentInformation')
            ->with(
                $formattedNumber,
                ZugferdInvoiceType::INVOICE,
                $this->callback(function ($dateTime) use ($dateFormat, $date) {
                    return $dateTime instanceof \DateTime &&
                        $dateTime->format($dateFormat) === $date;
                }),
                $currencyName
            )
            ->willReturn($builderSpy);

        $builderSpy->expects($this->once())
            ->method('setDocumentBusinessProcess')
            ->with(BuilderDocumentInformationConfigurator::PROCESS_ID)
            ->willReturn($builderSpy);

        $sut = new BuilderDocumentInformationConfigurator(
            formatCalculator: $formatCalculator,
        );

        $result = $sut->configureBuilder($builderSpy, $invoiceDataStub);
        $this->assertSame($builderSpy, $result);
    }
}
