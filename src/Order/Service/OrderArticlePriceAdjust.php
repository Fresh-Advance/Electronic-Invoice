<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Order\Service;

use OxidEsales\Eshop\Application\Model\Order;

class OrderArticlePriceAdjust implements OrderArticlePriceAdjustInterface
{
    public function __construct(
        private readonly OrderDifferenceCalculatorInterface $orderDifferenceCalculator,
    ) {
    }

    public function adjustNetValueByOrder(float $netPrice, Order $order): float
    {
        return round(
            $netPrice / $this->orderDifferenceCalculator->getNetDifferenceCoefficient($order),
            2
        );
    }

    public function adjustVatValueByOrder(float $vatValue, Order $order): float
    {
        return round(
            $vatValue / $this->orderDifferenceCalculator->getVatDifferenceCoefficient($order),
            2
        );
    }
}
