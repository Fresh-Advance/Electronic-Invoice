<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Tests\Unit\Order\Service;

use FreshAdvance\ElectronicInvoice\Order\Service\OrderDifferenceCalculator;
use FreshAdvance\ElectronicInvoice\Order\Service\OrderDifferenceCalculatorInterface;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\EshopCommunity\Application\Model\OrderArticleList;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OrderDifferenceCalculatorTest extends TestCase
{
    #[Test]
    public function calculationNetDifferenceWithItems(): void
    {
        $orderArticle1 = $this->createStub(OrderArticle::class);
        $orderArticle1->method('getFieldData')->willReturnMap([
            ['OXNETPRICE', (float)$netPrice1 = rand(1, 100)],
        ]);

        $orderArticle2 = $this->createStub(OrderArticle::class);
        $orderArticle2->method('getFieldData')->willReturnMap([
            ['OXNETPRICE', (float)$netPrice2 = rand(1, 100)],
        ]);

        $orderStub = $this->createMock(\OxidEsales\Eshop\Application\Model\Order::class);
        $orderStub->method('getOrderArticles')->willReturn(
            $this->createConfiguredStub(OrderArticleList::class, [
                'getArray' => [
                    $orderArticle1,
                    $orderArticle2,
                ]
            ])
        );
        $orderStub->method('getFieldData')->willReturnMap([
            ['OXTOTALNETSUM', (float)$totalNetSum = rand(20, 200)],
        ]);

        $sut = $this->getSut();

        $result = $sut->getNetDifferenceCoefficient($orderStub);
        $this->assertSame((float)(($netPrice1 + $netPrice2) / $totalNetSum), $result);
    }

    #[Test]
    public function calculationNetDifferenceWithTotalZero(): void
    {
        $orderStub = $this->createMock(\OxidEsales\Eshop\Application\Model\Order::class);
        $orderStub->method('getOrderArticles')->willReturn(
            $this->createConfiguredStub(OrderArticleList::class, [
                'getArray' => []
            ])
        );
        $orderStub->method('getFieldData')->willReturnMap([
            ['OXTOTALNETSUM', 0],
        ]);

        $sut = $this->getSut();

        $result = $sut->getNetDifferenceCoefficient($orderStub);
        $this->assertSame(1.0, $result);
    }

    #[Test]
    public function calculationNetDifferenceWithNoItems(): void
    {
        $orderStub = $this->createMock(\OxidEsales\Eshop\Application\Model\Order::class);
        $orderStub->method('getFieldData')->willReturnMap([
            ['OXTOTALNETSUM', rand(20, 200)],
        ]);
        $orderStub->method('getOrderArticles')->willReturn(
            $this->createConfiguredStub(OrderArticleList::class, [
                'getArray' => []
            ])
        );
        $sut = $this->getSut();

        $result = $sut->getNetDifferenceCoefficient($orderStub);
        $this->assertSame(0.0, $result);
    }

    #[Test]
    public function calculationVatDifferenceWithItems(): void
    {
        $orderArticle1 = $this->createStub(OrderArticle::class);
        $orderArticle1->method('getFieldData')->willReturnMap([
            ['OXVATPRICE', (float)$vatPrice1 = rand(1, 100)],
        ]);

        $orderArticle2 = $this->createStub(OrderArticle::class);
        $orderArticle2->method('getFieldData')->willReturnMap([
            ['OXVATPRICE', (float)$vatPrice2 = rand(1, 100)],
        ]);

        $orderStub = $this->createMock(\OxidEsales\Eshop\Application\Model\Order::class);
        $orderStub->method('getOrderArticles')->willReturn(
            $this->createConfiguredStub(OrderArticleList::class, [
                'getArray' => [
                    $orderArticle1,
                    $orderArticle2,
                ]
            ])
        );
        $orderStub->method('getFieldData')->willReturnMap([
            ['OXTOTALNETSUM', (float)$totalNetSum = rand(50, 100)],
            ['OXTOTALBRUTSUM', (float)$totalBrutSum = rand(101, 200)],
        ]);

        $sut = $this->getSut();

        $this->assertSame(
            (float)(($vatPrice1 + $vatPrice2) / ($totalBrutSum - $totalNetSum)),
            $sut->getVatDifferenceCoefficient($orderStub)
        );
    }

    #[Test]
    public function calculationVatDifferenceWithTotalZero(): void
    {
        $orderStub = $this->createMock(\OxidEsales\Eshop\Application\Model\Order::class);
        $orderStub->method('getOrderArticles')->willReturn(
            $this->createConfiguredStub(OrderArticleList::class, [
                'getArray' => []
            ])
        );
        $orderStub->method('getFieldData')->willReturnMap([
            ['OXTOTALNETSUM', 0],
            ['OXTOTALBRUTSUM', 0],
        ]);

        $sut = $this->getSut();

        $result = $sut->getVatDifferenceCoefficient($orderStub);
        $this->assertSame(1.0, $result);
    }

    #[Test]
    public function calculationVatDifferenceWithNoItems(): void
    {
        $orderStub = $this->createMock(\OxidEsales\Eshop\Application\Model\Order::class);
        $orderStub->method('getFieldData')->willReturnMap([
            ['OXTOTALNETSUM', rand(50, 100)],
            ['OXTOTALBRUTSUM', rand(101, 200)],
        ]);
        $orderStub->method('getOrderArticles')->willReturn(
            $this->createConfiguredStub(OrderArticleList::class, [
                'getArray' => []
            ])
        );

        $sut = $this->getSut();

        $result = $sut->getVatDifferenceCoefficient($orderStub);
        $this->assertSame(0.0, $result);
    }

    private function getSut(): OrderDifferenceCalculatorInterface
    {
        return new OrderDifferenceCalculator();
    }
}
