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
        Schema::create('foodspots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->index('user_id');
            $table->string('name');
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->unsignedInteger('visits')->default(0);
            $table->string('contact_number')->nullable();
            $table->string('email')->nullable();
            $table->string('category_tag')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('tagline')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foodspots');
    }
};
