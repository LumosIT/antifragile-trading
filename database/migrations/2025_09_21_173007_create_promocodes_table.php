<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocodes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 8);
            $table->string('type');
            $table->unsignedInteger('value');
            $table->timestamp('expired_at')->nullable();
            $table->unsignedInteger('current_uses')->default(0);
            $table->unsignedInteger('max_uses');
            $table->boolean('only_first_payment')->default(false);
            $table->unsignedInteger('bonus_duration')->nullable();
            $table->string('bonus_period')->nullable();
            $table->timestamps();

            $table->unique('code');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocodes');
    }
}
