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
use PHPUnit\Framework\Attributes\DataProvider;
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
    public function store_movement (): void
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
    public function show_movements_only_for_this_recording (): void
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
    public function movements_computed_property(): void
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
    #[DataProvider('dataProviderCanSnapshotCurrentStatus')]
    public function can_snapshot_current_status (int $current, int $snapshot, int $expectedAmount): void
    {
        $movement = Movement::factory()->has(Recording::factory()->state([
            'parent_id' => $this->bucket->recording->id,
        ]))->create(['amount' => $current]);

        Livewire::test(Overview::class, [
            'recordingBucket' => $this->bucket->recording,
        ])
            ->set('movement', $snapshot)
            ->set('notes', 'lorem ipsum')
            ->set('isSnapshot', 1)
            ->call('store')
            ->assertSet('movement', null)
            ->assertSet('isSnapshot', false)
            ->assertSet('notes', null);

        $this->assertDatabaseHas('movements', [
            'amount' => $expectedAmount * 100,
            'notes' => '(snapshot) lorem ipsum',
            'is_snapshot' => true,
        ]);
    }

    public static function dataProviderCanSnapshotCurrentStatus()
    {
        return [
            'positive' => [1000, 2500, 1500],
            'negative' => [2500, 1000, -1500],
            'substract positive' => [1000, -500, -1500],
            'substract negative' => [500, -500, -1000],
        ];
    }

    #[Test]
    public function when_creating_an_snapshot_from_empty_movements(): void
    {
        Livewire::test(Overview::class, [
            'recordingBucket' => $this->bucket->recording,
        ])
            ->set('movement', 1000)
            ->set('notes', 'lorem ipsum')
            ->set('isSnapshot', 1)
            ->call('store')
            ->assertSet('movement', null)
            ->assertSet('isSnapshot', false)
            ->assertSet('notes', null);

        $this->assertDatabaseHas('movements', [
            'amount' => 100000,
            'notes' => '(snapshot) lorem ipsum',
            'is_snapshot' => true,
        ]);
    }



}
