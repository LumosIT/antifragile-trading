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
        Schema::create('dialogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');

            $table->timestamps();
            $table->foreign('client_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('dialog_id');
            $table->boolean('read')->default(false);
            $table->string('author')->default('client');
            $table->longText('text')->nullable();
            $table->string('file_path')->nullable();
            $table->boolean('file_exist')->default(false);

            $table->timestamps();
            $table->foreign('client_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('dialog_id')
                ->references('id')
                ->on('dialogs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dialogs');
        Schema::dropIfExists('messages');
    }
};