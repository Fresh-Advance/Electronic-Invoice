<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Tests\Codeception\Acceptance;

use OxidEsales\Codeception\Module\Translation\Translator;
use FreshAdvance\ElectronicInvoice\Tests\Codeception\Support\AcceptanceTester;

/**
 * @group fa_electronic_invoice
 * @group fa_electronic_invoice_startpage
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
