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
        Schema::create('schedulers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('scheduled_at')->nullable();
            $table->enum('frequency', ['once', 'every_weekday', 'every_day']);
            $table->json('scheduled_contact')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('message_id')->constrained('messages')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedulers');
    }
};
