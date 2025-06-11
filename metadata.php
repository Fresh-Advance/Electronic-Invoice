<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

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
    'version' => '1.0.0-rc.3',
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
    ]
];
