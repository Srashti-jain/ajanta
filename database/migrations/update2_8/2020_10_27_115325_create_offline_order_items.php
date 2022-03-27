<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflineOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('offline_order_items')){
            Schema::create('offline_order_items', function (Blueprint $table) {
                $table->id();
                $table->integer('order_id')->unsigned();
                $table->text('product_name');
                $table->double('product_price');
                $table->integer('product_qty')->unsigned();
                $table->string('origin')->nullable();
                $table->double('product_total');
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
        Schema::dropIfExists('offline_order_items');
    }
}
