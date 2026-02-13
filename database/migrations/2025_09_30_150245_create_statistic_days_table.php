<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistic_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');

            //К текущей дате
            $table->unsignedInteger('registers')->default(0);
            $table->unsignedInteger('activities')->default(0);

            $table->unsignedInteger('sells')->default(0);
            $table->unsignedInteger('sells_new')->default(0);
            $table->unsignedInteger('sells_after_cancel')->default(0);
            $table->unsignedInteger('sells_continues_first')->default(0);
            $table->unsignedInteger('sells_continues')->default(0);
            $table->unsignedInteger('cancels')->default(0);

            $table->unique('date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistic_days');
    }
}
