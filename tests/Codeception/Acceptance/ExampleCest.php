<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\ModuleTemplate\Tests\Codeception\Acceptance;

use OxidEsales\Codeception\Module\Translation\Translator;
use OxidEsales\ModuleTemplate\Tests\Codeception\Support\AcceptanceTester;

/**
 * @group oe_moduletemplate
 * @group oe_moduletemplate_startpage
 */
final class ExampleCest
{
    public function testCanOpenShopStartPage(AcceptanceTester $I): void
    {
        $I->wantToTest('that codeception tests are working');

        $I->openShop();
        $I->waitForPageLoad();

        $I->see(Translator::translate('HOME'));
    }
}
