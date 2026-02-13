<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('mode');
            $table->unsignedInteger('duration');
            $table->string('period');
            $table->unsignedInteger('price');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index('mode');
        });

        Schema::table('users', function (Blueprint $table) {

            $table->unsignedBigInteger('tariff_id')->nullable();

            $table->index('tariff_id');

            $table->foreign('tariff_id')->references('id')->on('tariffs');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tariffs');
    }
}
