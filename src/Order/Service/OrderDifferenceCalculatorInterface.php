<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\ElectronicInvoice\Order\Service;

use OxidEsales\Eshop\Application\Model\Order;

interface OrderDifferenceCalculatorInterface
{
    public function getNetDifferenceCoefficient(Order $order): float;
    public function getVatDifferenceCoefficient(Order $order): float;
}
