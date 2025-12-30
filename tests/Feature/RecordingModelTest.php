<?php

namespace Tests\Feature;

use App\Models\Bucket;
use App\Models\Recording;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RecordingModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_add_morph_class (): void
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

    #[Test]
    public function can_get_recordable_attributes_from_recording (): void
    {
        $bucket = Bucket::factory()->has(Recording::factory())->create();

        $recording = Recording::record(Bucket::class)->first();

        $this->assertEquals($bucket->name, $recording->attr('name'));
        $this->assertEquals($bucket->goal, $recording->attr('goal'));
    }

    #[Test]
    public function can_check_type_of_recordable (): void
    {
        Bucket::factory()->has(Recording::factory())->create();

        $recording = Recording::record(Bucket::class)->first();

        $this->assertTrue($recording->isRecordable(Bucket::class));
    }



}
