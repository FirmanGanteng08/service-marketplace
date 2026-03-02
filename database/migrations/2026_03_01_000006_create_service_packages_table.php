<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('service_packages', function ($table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services');
            $table->string('name');
            $table->decimal('price', 15, 2);
            $table->integer('duration_days');
            $table->integer('revision_limit');
            $table->json('features');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_packages');
    }
};
