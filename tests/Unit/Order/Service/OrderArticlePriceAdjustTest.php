<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Tests\Unit\Order\Service;

use FreshAdvance\ElectronicInvoice\Order\Service\OrderDifferenceCalculatorInterface;
use FreshAdvance\ElectronicInvoice\Order\Service\OrderArticlePriceAdjust;
use Generator;
use OxidEsales\Eshop\Application\Model\Order;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OrderArticlePriceAdjustTest extends TestCase
{
    public static function checkPriceDividedByCoefficientDataProvider(): Generator
    {
        yield 'order value bigger then article sum' => [
            'coefficient' => 1.1,
            'input' => 100,
            'expected' => 90.91,
        ];

        yield 'order value is the same as article sum' => [
            'coefficient' => 1.0,
            'input' => 100,
            'expected' => 100.00,
        ];

        yield 'order value is lower then article sum' => [
            'coefficient' => 0.9,
            'input' => 100,
            'expected' => 111.11,
        ];
    }

    #[Test]
    #[DataProvider('checkPriceDividedByCoefficientDataProvider')]
    public function checkNetPriceDividedByCoefficient(
        float $coefficient,
        float $input,
        float $expected
    ): void {
        $orderStub = $this->createStub(Order::class);

        $netDifferenceCalculatorMock = $this->createMock(OrderDifferenceCalculatorInterface::class);
        $netDifferenceCalculatorMock->method('getNetDifferenceCoefficient')
            ->with($orderStub)
            ->willReturn($coefficient);

        $sut = $this->getSut($netDifferenceCalculatorMock);

        $this->assertSame($expected, $sut->adjustNetValueByOrder($input, $orderStub));
    }

    #[Test]
    #[DataProvider('checkPriceDividedByCoefficientDataProvider')]
    public function checkVatPriceMultipliedByCoefficient(
        float $coefficient,
        float $input,
        float $expected
    ): void {
        $orderStub = $this->createStub(Order::class);

        $netDifferenceCalculatorMock = $this->createMock(OrderDifferenceCalculatorInterface::class);
        $netDifferenceCalculatorMock->method('getVatDifferenceCoefficient')
            ->with($orderStub)
            ->willReturn($coefficient);

        $sut = $this->getSut($netDifferenceCalculatorMock);

        $this->assertSame($expected, $sut->adjustVatValueByOrder($input, $orderStub));
    }

    private function getSut(
        ?OrderDifferenceCalculatorInterface $netDifferenceCalculator = null,
    ) {
        return new OrderArticlePriceAdjust(
            orderDifferenceCalculator: $netDifferenceCalculator
        );
    }
}
