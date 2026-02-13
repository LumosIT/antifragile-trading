<?php

use App\Consts\OrderStatuses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->unsignedBigInteger('promocode_id')->nullable();
            $table->unsignedBigInteger('tariff_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('amount');
            $table->string('status')->default(OrderStatuses::ACTIVE);
            $table->timestamps();

            $table->unique('code');
            $table->index('tariff_id');
            $table->index('user_id');
            $table->index('status');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('promocode_id')->references('id')->on('promocodes')->onDelete('set null');
            $table->foreign('tariff_id')->references('id')->on('tariffs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_data');
    }
}
