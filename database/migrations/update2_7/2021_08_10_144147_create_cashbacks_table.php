<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cashbacks')){
            Schema::create('cashbacks', function (Blueprint $table) {
                $table->id();
                $table->integer('enable')->default(1)->unsigned();
                $table->integer('product_id')->unsigned()->nullable();
                $table->integer('simple_product_id')->unsigned()->nullable();
                $table->string('cashback_type');
                $table->string('discount_type');
                $table->double('discount');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashbacks');
    }
}
