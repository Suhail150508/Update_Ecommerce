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
       Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('discount_type',['Fixed','Percentage'])->nullable();
            $table->decimal('price',8, 2)->default(0);
            $table->text('product_ids')->nullable(); // Store as JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bundles');
    }
};
