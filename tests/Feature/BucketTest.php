<?php

namespace Tests\Feature;

use App\Livewire\Bucket;
use App\Models\Recording;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BucketTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function access_create_form(): void
    {
        $response = $this->get(route('bucket.create'));

        $response->assertSeeLivewire(Bucket\Create::class)
            ->assertSee('name="name"', false)
            ->assertSee('name="goal"', false);
    }

    #[Test]
    public function can_create_a_bucket (): void
    {
        $response = Livewire::test(Bucket\Create::class)
            ->set('name', 'test')
            ->set('goal', 1000)
            ->call('store');

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
        $response = Livewire::test(Bucket\Create::class)
            ->call('store');

        $response->assertHasErrors(['name', 'goal']);
        $this->assertDatabaseCount('buckets', 0);
    }

    #[Test]
    public function show_error_messages (): void
    {
        $this->followingRedirects();

        $response = Livewire::test(Bucket\Create::class)
            ->call('store');

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
            ->assertViewHas('buckets');
    }
}
