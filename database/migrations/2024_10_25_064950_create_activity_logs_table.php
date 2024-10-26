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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // ID of the user performing the action
            $table->string('action'); // Description of the action
            $table->string('subject_type')->nullable(); // Model name (e.g., Task, Product)
            $table->unsignedBigInteger('subject_id')->nullable(); // ID of the subject (model)
            $table->json('properties')->nullable(); // Optional: store additional data in JSON format
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
