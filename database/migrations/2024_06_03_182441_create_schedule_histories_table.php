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
        // ['contacts', 'message', 'delivered_at', 'frequency', 'status']
        Schema::create('schedule_histories', function (Blueprint $table) {
            $table->id();
            $table->text('contacts');
            $table->string('message');
            $table->dateTime('delivered_at');
            $table->string('frequency');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_histories');
    }
};
