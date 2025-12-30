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

    #[Test]
    public function comparisons ()
    {
        $money = Money::fromNative(634.32);

        $this->assertTrue($money->equal(Money::fromNative(634.32)), 'Two values aren\'t equal');
        $this->assertFalse($money->equal(Money::fromNative(634.31)), 'Two values are equals');
    }

    #[Test]
    public function format_number ()
    {
        $money = Money::fromNative(1634.52);

        $this->assertEquals('1 634,52', $money->format());
        $this->assertEquals('1 635', $money->format(decimals: 0));
        $this->assertEquals('1 634.5', $money->format(decimals: 1, decimalSeparator: '.'));
        $this->assertEquals('€ 1 634,52', $money->format('€'));
    }
}
