<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('content_id')->constrained()->cascadeOnDelete();

            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();

            $table->index('enrollment_id');
            $table->index('content_id');

            $table->unique(['enrollment_id', 'content_id'], 'unique_progress');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress');
    }
};
