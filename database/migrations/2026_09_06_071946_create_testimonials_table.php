<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name', 100);
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('review');
            $table->string('avatar')->nullable();
            $table->boolean('is_published')->default(false);
            $table->tinyInteger('sort_order')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};