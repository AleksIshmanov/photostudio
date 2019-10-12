<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
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
            $table->text('name');
            $table->integer('portraits_count')->unsigned(); //Портретов инд. в альбом
            $table->integer('photo_common')->unsigned(); //Всего фотографий
            $table->integer('photo_individual'); //Общих фото кокретному владельцу
            $table->text('client_link')->unique();
            $table->text('confirm_key')->unique();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
