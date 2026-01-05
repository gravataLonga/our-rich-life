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
            'recordingBucket' => $this->bucket->recording,
        ])
            ->set('movement', 1000)
            ->set('notes', 'lorem ipsum')
            ->call('store');

        $bucket->assertSet('movement', null)
            ->assertSet('notes', null)
            ->assertDispatched('movement-stored')
            ->assertSee('€ 1 000,00');
        $this->assertDatabaseCount('recordings', 2);
        $this->assertDatabaseCount('movements', 1);
        $this->assertDatabaseHas('movements', [
            'amount' => 100000,
            'notes' => 'lorem ipsum',
        ]);
        $this->assertDatabaseHas('recordings', [
            'parent_id' => $this->bucket->recording->id,
            'recordable_type' => Movement::class,
        ]);
    }

    #[Test]
    public function show_movements_only_for_this_recording ()
    {
        $movementOne = Movement::factory()->has(Recording::factory()->state([
            'parent_id' => $this->bucket->recording->id,
        ]))->create(['notes' => 'lorem ipsum']);
        $movementTwo = Movement::factory()->has(Recording::factory()->state([
            'parent_id' => 9999,
        ]))->create();

        Livewire::test(Overview::class, [
            'recordingBucket' => $this->bucket->recording,
        ])
            ->assertSee($movementOne->amount->format('€'))
            ->assertSee('lorem ipsum')
            ->assertDontSee($movementTwo->amount->format('€'));
    }

    #[Test]
    public function movements_computed_property()
    {
        $status = Livewire::test(Overview::class, [
            'recordingBucket' => $this->bucket->recording,
        ])->get('movements');

        $this->assertCount(0, $status);

        Movement::factory()
            ->has(Recording::factory()->state(['parent_id' => $this->bucket->recording->id]))
            ->create();

        $status = Livewire::test(Overview::class, [
            'recordingBucket' => $this->bucket->recording,
        ])->get('movements');

        $this->assertCount(1, $status);
    }

    #[Test]
    public function can_snapshot_current_status ()
    {
        $this->markTestSkipped('in progress...');
        $movement = Movement::factory()->has(Recording::factory()->state([
            'parent_id' => $this->bucket->recording->id,
        ]))->create(['amount' => 1000]);

        Livewire::test(Overview::class, [
            'recordingBucket' => $this->bucket->recording,
        ])
            ->set('movement', 2500)
            ->set('notes', 'lorem ipsum')
            ->call('snapshot')
            ->assertSet('movement', null)
            ->assertSet('notes', null);

        $this->assertDatabaseHas('movements', [
            'amount' => 150000,
            'notes' => '(snapshot) lorem ipsum',
            'is_snapshot' => true,
        ]);
    }


}
