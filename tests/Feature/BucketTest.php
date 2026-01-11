<?php

namespace Tests\Feature;

use App\Livewire\Bucket;
use App\Models\Event;
use App\Models\Movement;
use App\Models\Recording;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BucketTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
        $this->withoutVite();
    }

    #[Test]
    public function overview (): void
    {
        $this->get(route('bucket.overview'))
            ->assertSeeLivewire(Bucket\Overview::class);
    }

    #[Test]
    public function access_create_form(): void
    {
        $response = $this->get(route('bucket.form.create'));

        $response->assertSeeLivewire(Bucket\Form::class)
            ->assertSee('name="name"', false)
            ->assertSee('name="goal"', false);
    }

    #[Test]
    public function it_can_store (): void
    {
        $response = Livewire::test(Bucket\Form::class, ['recording' => null])
            ->set('name', 'test')
            ->set('goal', 1000)
            ->call('save');

        $response->assertSet('name', 'test');
        $response->assertSet('goal', 1000);
        $response->assertHasNoErrors();
        $response->assertRedirect(route('bucket.overview'));
        $this->assertDatabaseCount('buckets', 1);
        $this->assertDatabaseHas('buckets', [
            'name' => 'test',
            'goal' => 100000,
        ]);
        $this->assertDatabaseCount('recordings', 1);
        $this->assertDatabaseHas('recordings', [
            'recordable_id' => 1,
            'recordable_type' => \App\Models\Bucket::class,
            'user_id' => auth()->id(),
        ]);
        $this->assertDatabaseCount('events', 1);
        $this->assertDatabaseHas('events', [
            'recordable_id' => 1,
            'recording_id' => 1,
        ]);
    }

    #[Test]
    public function access_update_form (): void
    {
        $bucket = \App\Models\Bucket::factory()->has(
            Recording::factory()
        )->create();

        $this->get(route('bucket.form.edit', $bucket->recording))
            ->assertSeeLivewire(Bucket\Form::class);
    }

    #[Test]
    public function cant_access_update_form_if_not_of_authenticated_user ()
    {
        $bucket = \App\Models\Bucket::factory()->has(
            Recording::factory()->state(['user_id' => User::factory()->create()->id])
        )->create();

        $this->get(route('bucket.form.edit', $bucket->recording))
            ->assertForbidden(route('bucket.overview'));
    }

    #[Test]
    public function validate_data_before_saving_it (): void
    {
        $response = Livewire::test(Bucket\Form::class)
            ->call('save');

        $response->assertHasErrors(['name', 'goal']);
        $this->assertDatabaseCount('buckets', 0);
    }

    #[Test]
    public function show_error_messages (): void
    {
        $this->followingRedirects();

        $response = Livewire::test(Bucket\Form::class)
            ->call('save');

        $response->assertHasErrors(['name', 'goal']);
        $this->assertDatabaseCount('buckets', 0);
        $response->assertSee('The name field is required.');
        $response->assertSee('The goal field is required.');
    }

    #[Test]
    public function list_buckets (): void
    {
        $notShow = \App\Models\Bucket::factory()->has(Recording::factory()->state(['user_id' => 2]))->create();
        \App\Models\Bucket::factory()->count(5)->has(Recording::factory()->state(['user_id' => 1]))->create();
        $response = Livewire::test(Bucket\Overview::class);

        $response->assertSuccessful();
        $response->assertCount('recordings', 5);
        $response->assertDontSee($notShow->name);
    }

    #[Test]
    public function can_edit_bucket (): void
    {
        \App\Models\Bucket::factory()->has(Recording::factory())->create();
        $recording = Recording::with('recordable')->first();

        $response = Livewire::test(Bucket\Form::class, ['recording' => $recording]);

        $response->assertSuccessful()
            ->assertViewHas('name', $recording->recordable->name)
            ->assertViewHas('goal', $recording->recordable->goal->toNative());
    }

    #[Test]
    public function update_bucket (): void
    {
        Carbon::setTestNow('2025-01-01 00:00:00');
        \App\Models\Bucket::factory()->has(Recording::factory())->create();
        $recording = Recording::with('recordable')->first();

        $response = Livewire::test(Bucket\Form::class, ['recording' => $recording])
            ->set('name', 'test')
            ->set('goal', 1000)
            ->call('save');

        $response->assertRedirectToRoute('bucket.overview');
        $this->assertDatabaseCount('buckets', 2);
        $this->assertDatabaseCount('recordings', 1);
        $this->assertDatabaseCount('events', 1);

        $this->assertDatabaseHas('buckets', [
            'name' => 'test',
            'goal' => 100000,
        ]);
        $this->assertDatabaseHas('events', [
            'recordable_id' => 2,
            'recording_id' => 1,
            'occurred_at' => '2025-01-01 00:00:00',
        ]);
    }

    #[Test]
    public function can_access_form_for_update (): void
    {
        $bucket = \App\Models\Bucket::factory()->has(Recording::factory())->create();

        $this->get(route('bucket.form.edit', $bucket->recording))
            ->assertSeeLivewire(Bucket\Form::class)
            ->assertDontSee('recover')
            ->assertSee('current');
    }

    #[Test]
    public function can_recover_past_history(): void
    {
        $bucketOne = \App\Models\Bucket::factory()->create();
        $bucketTwo = \App\Models\Bucket::factory()->create();
        $recording = $bucketOne->recording()->create([
            'user_id' => auth()->id(),
        ]);
        $bucketOne->events()->create([
            'recording_id' => $recording->id,
            'occurred_at' => now()
        ]);
        $bucketTwo->events()->create([
            'recording_id' => $recording->id,
            'occurred_at' => now()
        ]);

        $response = $this->get(route('bucket.form.edit', $bucketOne->recording))
            ->assertSeeLivewire(Bucket\Form::class)
            ->assertSee('recover(2)')
            ->assertSee('current');
    }


    #[Test]
    public function it_can_recover_past_buckets (): void
    {
        $bucketOne = \App\Models\Bucket::factory()->create();
        $bucketTwo = \App\Models\Bucket::factory()->create();
        $recording = $bucketOne->recording()->create([
            'user_id' => auth()->id(),
        ]);
        $event = $bucketTwo->events()->create([
            'recording_id' => $recording->id,
            'occurred_at' => now()
        ]);

        $response = Livewire::test(Bucket\Form::class, ['recording' => $recording])
            ->call('recover', $event);

        $this->assertDatabaseCount('buckets', 2);
        $this->assertDatabaseHas('recordings', [
            'recordable_type' => \App\Models\Bucket::class,
            'recordable_id' => $bucketTwo->id,
        ]);
        $response->assertViewHas('name', $bucketTwo->name);
        $response->assertViewHas('goal', $bucketTwo->goal->toNative());
    }

    #[Test]
    public function show_movements (): void
    {
        $bucket = \App\Models\Bucket::factory()->has(Recording::factory())->create();

        $response = Livewire::test(Bucket\Card::class, ['recording' => $bucket->recording])
            ->call('movementShow');

        $response->assertDispatched('movementShow', fn(string $eventName, mixed $params): bool => count($params) === 1 && $params['recordingId'] === $bucket->recording->id);
    }

    #[Test]
    public function set_recording_to_show_movements (): void
    {
        $bucket = \App\Models\Bucket::factory()->has(Recording::factory()->state(['user_id' => 1]))->create();

        $response = Livewire::test(Bucket\Overview::class)
            ->call('movementShowEvent', $bucket->recording->id);

        $response->assertSet('recordingBucket', fn($value): bool => $value->id == $bucket->recording->id);
        $response->assertSeeLivewire('movement.overview');
    }

    #[Test]
    public function show_total_movements_and_percentage (): void
    {
        $bucket = \App\Models\Bucket::factory()->has(
            Recording::factory()->state(['user_id' => auth()->id()])
        )->create([
            'goal' => 100000
        ]);
        Movement::factory()->has(Recording::factory()->state([
            'parent_id' => $bucket->recording->id,
            'user_id' => auth()->id(),
        ]))
            ->count(2)
            ->create(['amount' => 10000]);

        $response = Livewire::test(Bucket\Overview::class);

        $response->assertSee('20%');
        $response->assertSee('€ 20 000,00');
    }

}
