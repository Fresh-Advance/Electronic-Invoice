<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\ElectronicInvoice\Tests\Unit;

use FreshAdvance\ElectronicInvoice\Example;
use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{
    public function testUnitExample(): void
    {
        $example = new Example();
        $this->assertTrue($example->test());
    }
}
