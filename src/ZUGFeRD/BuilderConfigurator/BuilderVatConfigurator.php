<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator;

use FreshAdvance\ElectronicInvoice\Order\Service\OrderArticlePriceAdjustInterface;
use FreshAdvance\Invoice\DataType\InvoiceDataInterface;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\OrderArticle;

class BuilderVatConfigurator implements BuilderConfiguratorInterface
{
    public function __construct(
        private readonly OrderArticlePriceAdjustInterface $orderArticlePriceAdjust,
    ) {
    }

    public function configureBuilder(
        ZugferdDocumentBuilder $builder,
        InvoiceDataInterface $invoiceData
    ): ZugferdDocumentBuilder {
        $rates = $this->getOrderVatRates($invoiceData->getOrder());

        foreach ($rates as $vatRate => $values) {
            $builder->addDocumentTax(
                (float)$vatRate > 0 ? "S" : "Z",
                "VAT",
                (float)$values['net'],
                (float)$values['vat'],
                (float)$vatRate
            );
        }

        return $builder;
    }

    /**
     * @return array<string, array{net: float, vat: float}>
     */
    private function getOrderVatRates(Order $order): array
    {
        $rates = [];

        $items = $order->getOrderArticles()->getArray();
        /** @var OrderArticle $oneItem */
        foreach ($items as $oneItem) {
            $rates = $this->addVatValues(
                $rates,
                (float)$oneItem->getFieldData('OXVAT'),
                $this->orderArticlePriceAdjust->adjustNetValueByOrder(
                    (float)$oneItem->getFieldData('OXNETPRICE'),
                    $order,
                ),
                $this->orderArticlePriceAdjust->adjustVatValueByOrder(
                    (float)$oneItem->getFieldData('OXVATPRICE'),
                    $order,
                ),
            );
        }

        $deliveryPrice = $order->getOrderDeliveryPrice();
        $rates = $this->addVatValues(
            $rates,
            (float)$deliveryPrice->getVat(),
            (float)$deliveryPrice->getNettoPrice(),
            (float)$deliveryPrice->getVatValue()
        );

        $paymentPrice = $order->getOrderPaymentPrice();
        $rates = $this->addVatValues(
            $rates,
            (float)$paymentPrice->getVat(),
            (float)$paymentPrice->getNettoPrice(),
            (float)$paymentPrice->getVatValue()
        );

        $wrappingPrice = $order->getOrderWrappingPrice();
        $rates = $this->addVatValues(
            $rates,
            (float)$wrappingPrice->getVat(),
            (float)$wrappingPrice->getNettoPrice(),
            (float)$wrappingPrice->getVatValue()
        );

        return $rates;
    }

    /**
     * @param array<string, array{net: float, vat: float}> $rates
     *
     * @return array<string, array{net: float, vat: float}>
     */
    private function addVatValues(array $rates, float $vat, float $netPrice, float $vatPrice): array
    {
        $vatPercent = (string)$vat;
        if (!isset($rates[$vatPercent])) {
            $rates[$vatPercent] = [
                'net' => 0.0,
                'vat' => 0.0,
            ];
        }

        /** @var array{net: float, vat: float} $current */
        $current = $rates[$vatPercent];
        $current['net'] += $netPrice;
        $current['vat'] += $vatPrice;

        $rates[$vatPercent] = $current;

        /** @var array<string, array{net: float, vat: float}> $rates */
        return $rates;
    }
}
