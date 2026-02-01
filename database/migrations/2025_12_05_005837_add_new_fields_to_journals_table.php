<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->string('online_issn')->nullable()->after('issn');
            $table->string('print_issn')->nullable()->after('online_issn');
            $table->longText('focus_scope')->nullable()->after('aims_scope');
            $table->text('publication_frequency')->nullable()->after('focus_scope');
            $table->longText('peer_review_process')->nullable()->after('publication_frequency');
            $table->longText('open_access_policy')->nullable()->after('peer_review_process');
            $table->longText('editorial_team')->nullable()->after('editorial_board');
            $table->longText('author_guidelines')->nullable()->after('submission_guidelines');
        });
    }

    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn([
                'online_issn',
                'print_issn',
                'focus_scope',
                'publication_frequency',
                'peer_review_process',
                'open_access_policy',
                'editorial_team',
                'author_guidelines',
            ]);
        });
    }
};
