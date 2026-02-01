<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'notify_system')) {
                $table->boolean('notify_system')->default(true)->after('is_active');
            }
            if (!Schema::hasColumn('users', 'notify_marketing')) {
                $table->boolean('notify_marketing')->default(false)->after('notify_system');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'notify_marketing')) {
                $table->dropColumn('notify_marketing');
            }
            if (Schema::hasColumn('users', 'notify_system')) {
                $table->dropColumn('notify_system');
            }
        });
    }
};

