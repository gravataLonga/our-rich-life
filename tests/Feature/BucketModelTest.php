<?php

namespace Tests\Feature;

use App\Models\Bucket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use OurRichLife\Money;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BucketModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function cast_to_money_goal_field (): void
    {
        $bucket = Bucket::factory()->create(['goal' => 1000.42]);

        $this->assertDatabaseHas('buckets', [
            'goal' => 100042
        ]);
        $this->assertInstanceOf(Money::class, $bucket->goal);
    }

    #[Test]
    public function can_pass_money_instance (): void
    {
        $bucket = new Bucket();
        $bucket->name = "Hello";
        $bucket->goal = Money::fromNative('23.32');
        $bucket->save();

        $this->assertDatabaseHas('buckets', [
            'goal' => 2332
        ]);
        $this->assertInstanceOf(Money::class, $bucket->goal);
    }

    #[Test]
    public function after_retrieve_from_database_we_still_get_money_instance (): void
    {
        $bucket = new Bucket();
        $bucket->name = "Hello";
        $bucket->goal = Money::fromNative('23.32');
        $bucket->save();

        $bucket = Bucket::find(1);

        $this->assertInstanceOf(Money::class, $bucket->goal);
        $this->assertEquals(2332, $bucket->goal->value());
    }

    #[Test]
    public function calculate_percentage_by_provided_total_amount ()
    {
        $bucket = new Bucket();
        $bucket->name = "Hello";
        $bucket->goal = Money::fromNative(2000);

        $this->assertEquals(50, $bucket->calculatePercentage(100000));
        $this->assertEquals(0, $bucket->calculatePercentage(0));
        $this->assertEquals(0, $bucket->calculatePercentage(null));


    }
}
