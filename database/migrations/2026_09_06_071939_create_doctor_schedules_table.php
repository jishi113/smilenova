<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->tinyInteger('day_of_week')->comment('0=Sun,1=Mon,...,6=Sat');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedTinyInteger('slot_duration')->default(30)->comment('minutes');
            $table->unsignedTinyInteger('max_patients')->default(15);
            $table->boolean('is_active')->default(true);
            $table->unique(['doctor_id', 'day_of_week'], 'uq_doc_day');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};