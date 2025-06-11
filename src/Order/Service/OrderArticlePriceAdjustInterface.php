<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\ElectronicInvoice\Order\Service;

use OxidEsales\Eshop\Application\Model\Order;

interface OrderArticlePriceAdjustInterface
{
    public function adjustNetValueByOrder(float $netPrice, Order $order): float;

    public function adjustVatValueByOrder(float $vatValue, Order $order): float;
}
