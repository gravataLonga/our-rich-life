<?php

namespace Tests\Feature;

use App\Models\Bucket;
use App\Models\Recording;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RecordingModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_add_morph_class ()
    {
        $bucket = Bucket::factory()->create()
            ->recording()
            ->create();

        $this->assertDatabaseCount('recordings', 1);
        $this->assertDatabaseHas('recordings', [
            'recordable_type' => Bucket::class,
            'recordable_id' => $bucket->id,
        ]);
    }
}
