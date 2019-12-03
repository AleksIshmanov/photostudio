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

            $table->integer('photo_total')->unsigned(); //Всего фотографий
            $table->integer('portraits_count')->unsigned(); //Портретов инд. в альбом
            $table->integer('photo_individual'); //Общих фото кокретному владельцу
            $table->integer('designs_count');

            $table->string('photos_dir_name');
            $table->string('photos_link');

//            $table->text('client_link')->unique();
            $table->string('link_secret')->unique();
            $table->string('confirm_key')->unique();
            $table->longText('comment')->nullable();
            $table->boolean('is_closed')->default(false);
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
