<?php

namespace Tests\Feature;

use App\Livewire\Bucket;
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
    public function access_create_form()
    {
        $response = $this->get(route('bucket.create'));

        $response->assertSeeLivewire(Bucket\Create::class)
            ->assertSee('name="name"', false)
            ->assertSee('name="goal"', false);
    }

    #[Test]
    public function can_create_a_bucket ()
    {
        $response = Livewire::test(Bucket\Create::class)
            ->set('name', 'test')
            ->set('goal', 1000)
            ->call('store');

        $response->assertHasNoErrors();
        $this->assertDatabaseCount('buckets', 1);
        $this->assertDatabaseHas('buckets', [
            'name' => 'test',
            'goal' => 1000,
        ]);
        $this->assertDatabaseCount('recordings', 1);
        $this->assertDatabaseHas('recordings', [
            'record_id' => 1,
            'record_type' => \App\Models\Bucket::class,
            'group_id' => null,
        ]);
    }

    #[Test]
    public function validate_data_before_saving_it ()
    {
        $response = Livewire::test(Bucket\Create::class)
            ->call('store');

        $response->assertHasErrors(['name', 'goal']);
        $this->assertDatabaseCount('buckets', 0);
    }



}
