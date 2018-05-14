<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_clients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->string('promotion_id');
            $table->timestamps();

            //Foreign key
            /*$table->foreign('client_id')
                ->references('id')
                ->on('clientes')
                ->onDelete('cascade');

            $table->foreign('promotion_id')
                ->references('external_id')
                ->on('promotions')
                ->onDelete('cascade');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotion_clients');
    }
}
