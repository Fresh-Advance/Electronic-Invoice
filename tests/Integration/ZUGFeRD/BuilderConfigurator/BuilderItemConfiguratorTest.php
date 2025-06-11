<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Tests\Integration\ZUGFeRD\BuilderConfigurator;

use FreshAdvance\ElectronicInvoice\Order\Service\OrderArticlePriceAdjustInterface;
use FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator\BuilderItemConfigurator;
use FreshAdvance\Invoice\DataType\InvoiceDataInterface;
use FreshAdvance\Invoice\Pdf\Model\OrderArticleExtension;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use OxidEsales\Eshop\Application\Model\Order;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BuilderItemConfiguratorTest extends TestCase
{
    #[Test]
    public function configuresBuilderWithItem(): void
    {
        $position = rand(1, 100);

        $invoiceDataStub = $this->createConfiguredStub(InvoiceDataInterface::class, [
            'getLanguageId' => $languageId = rand(0, 100),
            'getOrder' => $orderStub = $this->createStub(Order::class),
        ]);

        $orderArticleMock = $this->createMock(OrderArticleExtension::class);
        $orderArticleMock->method('faGetTranslatedTitle')
            ->with($languageId)
            ->willReturn($title = uniqid());
        $orderArticleMock->method('getFieldData')
            ->willReturnMap([
                ['OXARTNUM', $artNum = uniqid()],
                ['OXNPRICE', (string)$oneNet = rand(10, 100)], // one net
                ['OXNETPRICE', (string)$totalNet = rand(100, 200)], // total net
                ['OXAMOUNT', (string)$amount = rand(1, 10)],
                ['OXVAT', (string)$vat = rand(10, 100)], // VAT percentage
            ]);

        $priceAdjustmentMock = $this->createMock(OrderArticlePriceAdjustInterface::class);
        $priceAdjustmentMock->method('adjustNetValueByOrder')
            ->willReturnMap([
                [(float)$oneNet, $orderStub, $oneNetAdjusted = (float)rand(10, 100)],
                [(float)$totalNet, $orderStub, $totalNetAdjusted = (float)rand(10, 100)],
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
            ->with($oneNetAdjusted);

        $builderSpy->expects($this->once())
            ->method('setDocumentPositionQuantity')
            ->with($amount, 'H87');

        $builderSpy->expects($this->once())
            ->method('addDocumentPositionTax')
            ->with('S', 'VAT', $vat);

        $builderSpy->expects($this->once())
            ->method('setDocumentPositionLineSummation')
            ->with($totalNetAdjusted);

        $sut = $this->getSut(
            priceAdjustmentMock: $priceAdjustmentMock,
        );

        $result = $sut->configureOneItem($builderSpy, $invoiceDataStub, $position, $orderArticleMock);

        $this->assertSame($builderSpy, $result);
    }

    public function getSut(
        ?OrderArticlePriceAdjustInterface $priceAdjustmentMock = null
    ): BuilderItemConfigurator {
        $priceAdjustmentMock ??= $this->createStub(OrderArticlePriceAdjustInterface::class);

        return new BuilderItemConfigurator(
            orderArticlePriceAdjust: $priceAdjustmentMock,
        );
    }
}
