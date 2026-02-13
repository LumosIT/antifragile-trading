<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('chat');
            $table->string('picture')->nullable();
            $table->integer('balance')->default(0);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('fio')->nullable();
            $table->boolean('meta_is_accept_rules')->default(false);
            $table->boolean('meta_is_buy')->default(false);
            $table->boolean('meta_is_pre_form_filled')->default(false);

            $table->unsignedInteger('stage')->default(0);
            $table->unsignedInteger('spam_stage')->default(0);
            $table->string('start_key')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('is_banned')->default(false);
            $table->boolean('is_alive')->default(true);
            $table->boolean('is_test_completed')->default(false);
            $table->string('memory')->nullable();

            $table->timestamp('first_payment_at')->nullable();
            $table->timestamp('died_at')->nullable();
            $table->timestamp('tariff_expired_at')->nullable();
            $table->timestamp('last_activity_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('last_spam_at')->nullable();
            $table->timestamp('test_started_at')->nullable();
            $table->timestamps();

            $table->unique('chat');
            $table->index('parent_id');
            $table->index('is_banned');
            $table->index('is_alive');
            $table->index('is_test_completed');
            $table->index('stage');
            $table->index('spam_stage');

            $table->foreign('parent_id')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
