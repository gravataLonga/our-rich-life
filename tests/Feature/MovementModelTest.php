<?php

namespace Tests\Feature;

use App\Models\Movement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use OurRichLife\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MovementModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function amount_is_cast_to_money ()
    {
        $movement = Movement::factory()->create(['amount' => 1000]);

        $this->assertInstanceOf(Money::class, $movement->amount);
        $this->assertEquals(1000, $movement->amount->toNative());
        $this->assertDatabaseHas('movements', [
            'amount' => 100000,
        ]);
    }
}
