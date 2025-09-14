<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Tests\Integration\ZUGFeRD\BuilderConfigurator;

use FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator\BuilderItemConfigurator;
use FreshAdvance\Invoice\InvoiceData\DataType\InvoiceDataInterface;
use FreshAdvance\Invoice\Pdf\Model\OrderArticleExtension;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use OxidEsales\Eshop\Application\Model\Order;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BuilderItemConfiguratorTest extends TestCase
{
    #[Test]
    public function configuresBuilderWithItemData(): void
    {
        $position = rand(1, 100);

        $orderArticleMock = $this->createMock(OrderArticleExtension::class);
        $orderArticleMock->method('getFieldData')
            ->willReturnMap([
                ['OXARTNUM', $artNum = uniqid()],
                ['OXNPRICE', (string)$oneNet = rand(10, 100)], // one net
                ['OXNETPRICE', (string)$totalNet = rand(100, 200)], // total net
                ['OXAMOUNT', (string)$amount = rand(1, 10)],
                ['OXTITLE', (string)$title = uniqid()],
            ]);

        $builderSpy = $this->createMock(ZugferdDocumentBuilder::class);

        $builderSpy->expects($this->once())
            ->method('addNewPosition')
            ->with($position);

        $builderSpy->expects($this->once())
            ->method('setDocumentPositionProductDetails')
            ->with($title, null, $artNum);

        $builderSpy->expects($this->once())
            ->method('setDocumentPositionNetPrice')
            ->with($oneNet);

        $builderSpy->expects($this->once())
            ->method('setDocumentPositionQuantity')
            ->with($amount, 'H87');

        $builderSpy->expects($this->once())
            ->method('setDocumentPositionLineSummation')
            ->with($totalNet);

        $sut = $this->getSut();

        $result = $sut->configureOneItem($builderSpy, $position, $orderArticleMock);

        $this->assertSame($builderSpy, $result);
    }

    public static function vatStateDataProvider(): \Generator
    {
        yield 'zero vat' => [
            'vat' => '0',
            'expectedVatType' => 'Z',
        ];

        yield 'standard vat' => [
            'vat' => (string)rand(1, 50),
            'expectedVatType' => 'S',
        ];
    }

    #[Test]
    #[DataProvider('vatStateDataProvider')]
    public function configuresOneItemCorrectVatState(string $vat, string $expectedVatType): void
    {
        $position = rand(1, 100);

        $orderArticleMock = $this->createMock(OrderArticleExtension::class);
        $orderArticleMock->method('getFieldData')
            ->willReturnMap([
                ['OXVAT', $vat], // VAT percentage
            ]);

        $builderSpy = $this->createMock(ZugferdDocumentBuilder::class);

        $builderSpy->expects($this->once())
            ->method('addDocumentPositionTax')
            ->with($expectedVatType, 'VAT', $vat);

        $sut = $this->getSut();

        $sut->configureOneItem($builderSpy, $position, $orderArticleMock);
    }

    public function getSut(): BuilderItemConfigurator
    {
        return new BuilderItemConfigurator();
    }
}
