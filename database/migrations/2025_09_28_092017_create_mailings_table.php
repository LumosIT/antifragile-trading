<?php

use App\Models\Mailing;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Consts\MailingStatuses;

class CreateMailingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('text');
            $table->unsignedInteger('messages_count')->default(0);
            $table->unsignedInteger('users_count')->default(0);
            $table->unsignedInteger('errors_count')->default(0);
            $table->unsignedBigInteger('last_user_id')->nullable();
            $table->string('status')->default(MailingStatuses::CREATED);
            $table->string('stages');
            $table->string('tariffs');
            $table->string('buttons');
            $table->unsignedBigInteger('file_id')->nullable();
            $table->timestamps();

            $table->index('status');

            $table->foreign('last_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('file_id')
                ->references('id')
                ->on('files')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailings');
    }
}
