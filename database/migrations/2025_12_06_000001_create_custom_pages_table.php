<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_id')->nullable()->constrained()->onDelete('cascade'); // NULL for global pages
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content')->nullable(); // HTML content
            $table->json('widgets')->nullable(); // Page builder widgets
            $table->json('settings')->nullable(); // Page settings
            $table->string('template')->default('default'); // Page template
            $table->boolean('is_published')->default(true);
            $table->integer('order')->default(0);
            $table->boolean('show_in_menu')->default(false);
            $table->string('menu_label')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_pages');
    }
};

