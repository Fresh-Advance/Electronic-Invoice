<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\ElectronicInvoice\Geo\Factory;

use OxidEsales\Eshop\Application\Model\Country;

interface CountryModelFactoryInterface
{
    public function createModelObject(): Country;
}
