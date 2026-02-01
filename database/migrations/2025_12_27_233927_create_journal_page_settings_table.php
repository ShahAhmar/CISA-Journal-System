<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('journal_page_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_id')->constrained()->onDelete('cascade');
            $table->string('page_key', 50); // 'about', 'info', 'editorial', 'apc', 'call_for_papers'
            $table->string('page_title');
            $table->string('menu_label', 100);
            $table->boolean('is_enabled')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();

            $table->unique(['journal_id', 'page_key']);
            $table->index('journal_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_page_settings');
    }
};
