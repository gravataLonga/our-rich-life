<?php

namespace Tests\Unit;

use OurRichLife\Money;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    #[Test]
    public function create_from_native (): void
    {
        $money = Money::fromNative(10.50);

        $this->assertEquals(1050, $money->value());
        $this->assertEquals(10.50, $money->toNative());
        $this->assertFalse($money->isNull());
    }

    #[Test]
    public function accept_null (): void
    {
        $money = Money::fromNative(null);

        $this->assertTrue($money->isNull());
        $this->assertEquals(null, $money->toNative());
        $this->assertEquals('€ 0,00', $money->format('€'));
    }

    #[Test]
    public function comparisons (): void
    {
        $money = Money::fromNative(634.32);

        $this->assertTrue($money->equal(Money::fromNative(634.32)), 'Two values aren\'t equal');
        $this->assertFalse($money->equal(Money::fromNative(634.31)), 'Two values are equals');
    }

    #[Test]
    public function format_number (): void
    {
        $money = Money::fromNative(1634.52);

        $this->assertEquals('1 634,52', $money->format());
        $this->assertEquals('1 635', $money->format(decimals: 0));
        $this->assertEquals('1 634.5', $money->format(decimals: 1, decimalSeparator: '.'));
        $this->assertEquals('€ 1 634,52', $money->format('€'));

        $money = new Money(163452);

        $this->assertEquals('1 634,52', $money->format());
        $this->assertEquals('1 635', $money->format(decimals: 0));
        $this->assertEquals('1 634.5', $money->format(decimals: 1, decimalSeparator: '.'));
        $this->assertEquals('€ 1 634,52', $money->format('€'));
    }

    #[Test]
    public function add_two_money_together (): void
    {
        $moneyOne = Money::fromNative(250);
        $moneyTwo = Money::fromNative(250);
        $moneySum = $moneyOne->add($moneyTwo);

        $this->assertEquals(500, $moneySum->toNative());
        $this->assertNotSame($moneyOne, $moneySum);
        $this->assertNotSame($moneyTwo, $moneySum);
        $this->assertEquals(250, $moneyOne->toNative());
        $this->assertEquals(250, $moneyTwo->toNative());
    }

    #[Test]
    public function sub_two_money_together (): void
    {
        $moneyOne = Money::fromNative(250);
        $moneyTwo = Money::fromNative(250);
        $moneySum = $moneyOne->sub($moneyTwo);

        $this->assertEquals(0, $moneySum->toNative());
        $this->assertNotSame($moneyOne, $moneySum);
        $this->assertNotSame($moneyTwo, $moneySum);
        $this->assertEquals(250, $moneyOne->toNative());
        $this->assertEquals(250, $moneyTwo->toNative());

        $moneyOne = Money::fromNative(500);
        $moneyTwo = Money::fromNative(300);
        $moneySum = $moneyOne->sub($moneyTwo);

        $this->assertEquals(200, $moneySum->toNative());
        $this->assertNotSame($moneyOne, $moneySum);
        $this->assertNotSame($moneyTwo, $moneySum);
        $this->assertEquals(500, $moneyOne->toNative());
        $this->assertEquals(300, $moneyTwo->toNative());

        $moneyOne = Money::fromNative(300);
        $moneyTwo = Money::fromNative(500);
        $moneySum = $moneyOne->sub($moneyTwo);

        $this->assertEquals(-200, $moneySum->toNative());
        $this->assertNotSame($moneyOne, $moneySum);
        $this->assertNotSame($moneyTwo, $moneySum);
        $this->assertEquals(300, $moneyOne->toNative());
        $this->assertEquals(500, $moneyTwo->toNative());

    }

}
