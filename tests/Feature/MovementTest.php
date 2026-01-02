<?php

namespace Tests\Feature;

use App\Livewire\Movement\Overview;
use App\Models\Bucket;
use App\Models\Movement;
use App\Models\Recording;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MovementTest extends TestCase
{
    use RefreshDatabase;

    private Bucket $bucket;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
        $this->bucket = Bucket::factory()->has(Recording::factory())->create();
    }

    #[Test]
    public function store_movement ()
    {
        $bucket = Livewire::test(Overview::class, [
            'recording' => $this->bucket->recording,
        ])
            ->set('movement', 1000)
            ->call('store');

        $this->assertDatabaseCount('recordings', 2);
        $this->assertDatabaseCount('movements', 1);
        $this->assertDatabaseHas('movements', [
            'amount' => 100000
        ]);
        $this->assertDatabaseHas('recordings', [
            'parent_id' => $this->bucket->recording->id,
            'recordable_type' => Movement::class,
        ]);
    }

}
