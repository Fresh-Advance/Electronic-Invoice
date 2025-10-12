<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

use FreshAdvance\ElectronicInvoice\Company\Settings\CompanySettings;
use FreshAdvance\ElectronicInvoice\Geo\Settings\GeoSettings;

$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id' => \FreshAdvance\ElectronicInvoice\Module::MODULE_ID,
    'title' => 'Electronic Invoice',
    'description' => 'Extension for PDF Invoice module to support electronic invoices.',
    'thumbnail' => 'logo.png',
    'version' => '1.0.1',
    'author' => 'Anton Fedurtsya',
    'email' => 'anton@fedurtsya.com',
    'url' => 'https://github.com/Fresh-Advance',
    'extend' => [],
    'settings' => [
        /** Main */
        [
            'group' => 'fa_electronic_invoice_main',
            'name' => GeoSettings::SETTING_SHOP_COUNTRY_ISO2,
            'type' => 'str',
            'value' => 'DE', // Default to Germany
        ],
        [
            'group' => 'fa_electronic_invoice_company',
            'name' => CompanySettings::SETTING_REGISTRY_NOTE,
            'type' => 'arr',
            'value' => [], // Default to empty array
        ],
    ]
];
