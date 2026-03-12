<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->string('title_id')->nullable()->after('title');
            $table->string('title_en')->nullable()->after('title_id');
            $table->text('content_id')->nullable()->after('content');
            $table->text('content_en')->nullable()->after('content_id');
        });

        // Copy existing data
        \Illuminate\Support\Facades\DB::table('tips')->update([
            'title_id' => \Illuminate\Support\Facades\DB::raw('title'),
            'content_id' => \Illuminate\Support\Facades\DB::raw('content'),
        ]);

        Schema::table('tips', function (Blueprint $table) {
            $table->dropColumn(['title', 'content']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tips', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->text('content')->nullable()->after('title');
        });

        // Copy data back
        \Illuminate\Support\Facades\DB::table('tips')->update([
            'title' => \Illuminate\Support\Facades\DB::raw('title_id'),
            'content' => \Illuminate\Support\Facades\DB::raw('content_id'),
        ]);

        Schema::table('tips', function (Blueprint $table) {
            $table->dropColumn(['title_id', 'title_en', 'content_id', 'content_en']);
        });
    }
};
