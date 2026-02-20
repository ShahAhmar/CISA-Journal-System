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
        Schema::table('journals', function (Blueprint $table) {
            $table->longText('vision')->nullable();
            $table->longText('mission')->nullable();
            $table->longText('apc_policy')->nullable();
            $table->longText('ethics_policy')->nullable();
            $table->longText('partnerships_content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            //
        });
    }
};
