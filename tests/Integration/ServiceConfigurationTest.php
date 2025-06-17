<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Tests\Integration;

use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;
use OxidEsales\EshopCommunity\Tests\TestContainerFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ServiceConfigurationTest extends IntegrationTestCase
{
    public static $cachedContainer;

    public static function setUpBeforeClass(): void
    {
        $container = (new TestContainerFactory())->create();
        $container->compile(true);
        self::$cachedContainer = $container;
    }

    public static function servicesProvider(): array
    {
        return [
            // Geo
            [\FreshAdvance\ElectronicInvoice\Geo\Factory\CountryModelFactoryInterface::class],
            [\FreshAdvance\ElectronicInvoice\Geo\Service\GeoServiceInterface::class],
            [\FreshAdvance\ElectronicInvoice\Geo\Settings\GeoSettingsInterface::class],

            // Order
            [\FreshAdvance\ElectronicInvoice\Order\Service\OrderArticlePriceAdjustInterface::class],
            [\FreshAdvance\ElectronicInvoice\Order\Service\OrderDifferenceCalculatorInterface::class],

            // ZUGFeRD
            [\FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator\BuilderConfiguratorInterface::class],
            [\FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator\BuilderItemConfiguratorInterface::class],
            [\FreshAdvance\ElectronicInvoice\ZUGFeRD\Factory\ZugferdXmlBuilderFactoryInterface::class],
            [\FreshAdvance\ElectronicInvoice\ZUGFeRD\Factory\ZugferdPdfMergerFactoryInterface::class],
            [\FreshAdvance\ElectronicInvoice\ZUGFeRD\Service\ZugferdXmlBuilderInterface::class],
            [\FreshAdvance\ElectronicInvoice\ZUGFeRD\Service\ZugferdPdfMergerInterface::class],
        ];
    }

    #[Test]
    #[DataProvider('servicesProvider')]
    public function serviceIsAvailable(string $serviceName): void
    {
        $service = self::$cachedContainer->get($serviceName);
        $this->assertInstanceOf($serviceName, $service);
    }
}
