<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recordings', function (Blueprint $table) {
            $table->id();
            $table->morphs('recordable');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->metadata();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recording_id');
            $table->morphs('recordable');
            $table->timestamp('occurred_at');
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_type_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
        });

        Schema::create('account_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color', 30)->nullable();
            $table->string('icon', 50)->nullable();
        });

        Schema::create('buckets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('goal');
        });

        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount');
            $table->tinyText('notes')->nullable();
            $table->boolean('was_absoluted_value')->default(false);
        });
    }
};
