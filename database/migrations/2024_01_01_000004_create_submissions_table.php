<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Author
            $table->string('title');
            $table->text('abstract');
            $table->text('keywords')->nullable();
            $table->string('status')->default('submitted'); // submitted, under_review, revision_requested, accepted, rejected, published
            $table->string('current_stage')->default('submission'); // submission, review, revision, copyediting, proofreading, published
            $table->foreignId('assigned_editor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('section_editor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('section')->nullable();
            $table->text('editor_notes')->nullable();
            $table->text('author_comments')->nullable();
            $table->string('doi')->nullable();
            $table->integer('page_start')->nullable();
            $table->integer('page_end')->nullable();
            $table->foreignId('issue_id')->nullable()->constrained()->onDelete('set null');
            $table->date('submitted_at');
            $table->date('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};

