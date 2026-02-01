<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role'); // journal_manager, editor, section_editor, reviewer, copyeditor, proofreader, sub_editor
            $table->string('section')->nullable(); // For section editors
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['journal_id', 'user_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_users');
    }
};

