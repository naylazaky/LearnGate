<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->restrictOnDelete();
            $table->string('title', 200);
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(true);
            $table->integer('student_count')->default(0);
            $table->timestamps();

            $table->index('category_id');
            $table->index('teacher_id');
            $table->index(['student_count', 'is_active'], 'popular_courses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
