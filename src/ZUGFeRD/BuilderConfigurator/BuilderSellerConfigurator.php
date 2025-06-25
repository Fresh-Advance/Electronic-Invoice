<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\ZUGFeRD\BuilderConfigurator;

use FreshAdvance\ElectronicInvoice\Geo\Settings\GeoSettingsInterface;
use FreshAdvance\Invoice\InvoiceData\DataType\InvoiceDataInterface;
use horstoeko\zugferd\codelists\ZugferdElectronicAddressScheme;
use horstoeko\zugferd\ZugferdDocumentBuilder;

class BuilderSellerConfigurator implements BuilderConfiguratorInterface
{
    public function __construct(
        private readonly GeoSettingsInterface $geoSettings,
    ) {
    }

    public function configureBuilder(
        ZugferdDocumentBuilder $builder,
        InvoiceDataInterface $invoiceData
    ): ZugferdDocumentBuilder {
        $shop = $invoiceData->getShop();

        $builder->setDocumentSeller(
            name: (string)$shop->getFieldData('OXCOMPANY'),
        );

        $builder->addDocumentSellerTaxNumber(
            taxNo: (string)$shop->getFieldData('OXTAXNUMBER'),
        );

        $builder->addDocumentSellerVATRegistrationNumber(
            vatRegNo: (string)$shop->getFieldData('OXVATNUMBER'),
        );

        $builder->setDocumentSellerAddress(
            lineOne: (string)$shop->getFieldData('OXSTREET'),
            postCode: (string)$shop->getFieldData('OXZIP'),
            city: (string)$shop->getFieldData('OXCITY'),
            country: $this->geoSettings->getShopCountryIso(),
        );

        $builder->setDocumentSellerContact(
            contactPersonName: sprintf(
                '%s %s',
                $shop->getFieldData('OXFNAME'),
                $shop->getFieldData('OXLNAME'),
            ),
            contactDepartmentName: null,
            contactPhoneNo: (string)$shop->getFieldData('OXTELEFON'),
            contactFaxNo: (string)$shop->getFieldData('OXTELEFAX'),
            contactEmailAddress: (string)$shop->getFieldData('OXINFOEMAIL'),
        );

        $builder->setDocumentSellerCommunication(
            uriScheme: ZugferdElectronicAddressScheme::UNECE3155_EM,
            uri: (string)$shop->getFieldData('OXINFOEMAIL'),
        );

        //@todo: $documentBuilder->setDocumentSellerOrderReferencedDocument('SO-2024-000993337');

        return $builder;
    }
}
