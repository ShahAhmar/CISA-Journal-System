<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->foreignId('section_editor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('word_limit_min')->nullable();
            $table->integer('word_limit_max')->nullable();
            $table->string('review_type')->default('double_blind'); // single_blind, double_blind, open
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('settings')->nullable(); // Additional settings
            $table->timestamps();
            
            $table->index(['journal_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_sections');
    }
};
