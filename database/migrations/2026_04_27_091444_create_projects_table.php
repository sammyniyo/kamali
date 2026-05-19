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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->enum('category', ['residential', 'commercial', 'civic'])->index();
            $table->enum('status', ['finished', 'under_construction'])->index();
            $table->string('cover_image')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('featured')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->string('architect_name')->nullable();
            $table->string('client_name')->nullable();
            $table->unsignedInteger('surface_area')->nullable(); // m²
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
