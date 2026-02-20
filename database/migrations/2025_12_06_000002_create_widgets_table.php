<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_id')->nullable()->constrained()->onDelete('cascade'); // NULL for global widgets
            $table->string('type'); // hero, text, image, gallery, testimonial, stats, latest_articles, etc.
            $table->string('name'); // Widget name/identifier
            $table->json('content'); // Widget content/settings
            $table->json('settings')->nullable(); // Additional settings
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->string('location')->nullable(); // homepage, sidebar, footer, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};

