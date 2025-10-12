<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Tests\Integration\ZUGFeRD\BuilderConfigurator;

use FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator\BuilderItemConfiguratorInterface;
use FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator\BuilderItemConfiguratorIterator;
use FreshAdvance\Invoice\InvoiceData\DataType\InvoiceDataInterface;
use horstoeko\zugferd\ZugferdDocumentBuilder;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Application\Model\OrderArticleList;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BuilderItemConfiguratorIteratorTest extends TestCase
{
    #[Test]
    public function iteratesThroughItemsAndTriggersBuilderConfigurationForEach(): void
    {
        $invoiceDataStub = $this->createConfiguredStub(InvoiceDataInterface::class, [
            'getOrder' => $this->createConfiguredStub(Order::class, [
                'getOrderArticles' => $this->createConfiguredStub(OrderArticleList::class, [
                    'getArray' => [
                        "10" => $item1 = $this->createStub(OrderArticle::class),
                        "20" => $item2 = $this->createStub(OrderArticle::class),
                    ]
                ]),
            ]),
        ]);

        $builderStub = $this->createMock(ZugferdDocumentBuilder::class);

        $builderItemConfiguratorSpy = $this->createMock(BuilderItemConfiguratorInterface::class);
        $builderItemConfiguratorSpy->expects($counter = $this->exactly(2))
            ->method('configureOneItem')
            ->willReturnCallback(function (
                ZugferdDocumentBuilder $builder,
                int $position,
                OrderArticle $orderArticle
            ) use (
                $counter,
                $builderStub,
                $item1,
                $item2
            ): ZugferdDocumentBuilder {
                switch ($counter->numberOfInvocations()) {
                    case 1:
                        $this->assertSame(1, $position);
                        $this->assertSame($item1, $orderArticle);
                        break;
                    case 2:
                        $this->assertSame(2, $position);
                        $this->assertSame($item2, $orderArticle);
                        break;
                }

                return $builder;
            });

        $sut = new BuilderItemConfiguratorIterator(
            builderItemConfigurator: $builderItemConfiguratorSpy,
        );

        $result = $sut->configureBuilder($builderStub, $invoiceDataStub);
        $this->assertSame($builderStub, $result);
    }
}
