<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_id')->constrained()->onDelete('cascade');
            $table->integer('volume')->nullable();
            $table->integer('issue_number')->nullable();
            $table->year('year');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->date('published_date')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            
            $table->unique(['journal_id', 'volume', 'issue_number', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};

