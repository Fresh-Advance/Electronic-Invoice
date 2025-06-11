<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Order\Service;

use OxidEsales\Eshop\Application\Model\Order;

class OrderDifferenceCalculator implements OrderDifferenceCalculatorInterface
{
    private function getItemFieldSum(Order $order, string $itemField): float
    {
        $orderArticles = $order->getOrderArticles()?->getArray();

        $articleFieldSum = 0.0;
        foreach ($orderArticles as $orderArticle) {
            $articleFieldSum += (float)$orderArticle->getFieldData($itemField);
        }

        return $articleFieldSum;
    }

    public function getNetDifferenceCoefficient(Order $order): float
    {
        $totalNetSum = (float)$order->getFieldData('OXTOTALNETSUM');
        if ($totalNetSum === 0.0) {
            return 1;
        }

        $itemFieldSum = $this->getItemFieldSum($order, 'OXNETPRICE');

        return $itemFieldSum / $totalNetSum;
    }

    public function getVatDifferenceCoefficient(Order $order): float
    {
        $totalVatSum = (float)$order->getFieldData('OXTOTALBRUTSUM')
            - (float)$order->getFieldData('OXTOTALNETSUM');
        if ($totalVatSum === 0.0) {
            return 1;
        }

        $itemFieldSum = $this->getItemFieldSum($order, 'OXVATPRICE');

        return $itemFieldSum / $totalVatSum;
    }
}
