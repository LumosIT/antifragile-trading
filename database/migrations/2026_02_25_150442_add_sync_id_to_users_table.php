<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('sync_id')
                ->nullable()
                ->after('id');

            $table->foreign('sync_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->index('sync_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['sync_id']);
            $table->dropIndex(['sync_id']);
            $table->dropColumn('sync_id');
        });
    }
};