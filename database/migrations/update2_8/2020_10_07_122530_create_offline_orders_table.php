<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflineOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('offline_orders')){
            Schema::create('offline_orders', function (Blueprint $table) {
                $table->id();
                $table->timestamp('invoice_date')->nullable();
                $table->string('order_id');
                $table->string('shipping_method');
                $table->double('shipping_rate');
                $table->string('txn_id');
                $table->string('payment_method');
                $table->string('order_status');
                $table->double('subtotal');
                $table->double('total_shipping');
                $table->double('tax_rate');
                $table->double('total_tax');
                $table->integer('tax_include')->unsigned()->default(0);
                $table->double('grand_total');
                $table->double('adjustable_amount')->default(0);
                $table->string('customer_name');
                $table->string('customer_id');
                $table->string('customer_email');
                $table->string('customer_phone');
                $table->longText('customer_shipping_address');
                $table->longText('customer_billing_address');
                $table->integer('country_id')->unsigned();
                $table->integer('state_id')->unsigned();
                $table->integer('city_id')->unsigned();
                $table->string('customer_pincode');
                $table->longText('additional_note')->nullable();
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
        Schema::dropIfExists('offline_orders');
    }
}
