<?php

namespace Tests\Feature;

use App\Livewire\Bucket;
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
    public function can_create_a_bucket (): void
    {
        $response = Livewire::test(Bucket\Form::class, ['recording' => null])
            ->set('name', 'test')
            ->set('goal', 1000)
            ->call('save');

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
            'group_id' => null,
        ]);
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
        \App\Models\Bucket::factory()->count(5)->has(Recording::factory())->create();
        $response = Livewire::test(Bucket\Overview::class);

        $response->assertSuccessful()
            ->assertViewHas('recordings');
    }

    #[Test]
    public function can_edit_bucket ()
    {
        \App\Models\Bucket::factory()->has(Recording::factory())->create();
        $recording = Recording::with('recordable')->first();

        $response = Livewire::test(Bucket\Form::class, ['recording' => $recording]);

        $response->assertSuccessful()
            ->assertViewHas('name', $recording->recordable->name)
            ->assertViewHas('goal', $recording->recordable->goal->toNative());
    }

    #[Test]
    public function update_bucket ()
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
            'recordable_id' => 1,
            'recording_id' => 1,
            'occurred_at' => '2025-01-01 00:00:00',
        ]);
    }

}
