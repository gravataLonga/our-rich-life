<?php

namespace Tests\Unit;

use OurRichLife\Money;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    #[Test]
    public function create_from_native ()
    {
        $money = Money::fromNative(10.50);

        $this->assertEquals(1050, $money->value());
        $this->assertEquals(10.50, $money->toNative());
        $this->assertFalse($money->isNull());
    }

    #[Test]
    public function accept_null ()
    {
        $money = Money::fromNative(null);

        $this->assertTrue($money->isNull());
        $this->assertEquals(null, $money->toNative());
    }
}
