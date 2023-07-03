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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('image_task', function (Blueprint $table) {
            $table->foreignId('task_id')->constrained()->primary()
                ->restrictOnUpdate()
                ->cascadeOnDelete();
                
            $table->foreignId('image_id')->constrained()->primary()
                ->restrictOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
        Schema::dropIfExists('task_image');
    }
};
