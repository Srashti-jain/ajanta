<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the Anonymous migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('simple_products',function(Blueprint $table){

            if (!Schema::hasColumn('simple_products', '360_image')) {
                $table->longText('360_image')->nullable();
            }

            if (!Schema::hasColumn('simple_products', 'sale_tag')) {
                $table->string('sale_tag')->nullable();
            }

            if (!Schema::hasColumn('simple_products', 'sale_tag_color')) {
                $table->string('sale_tag_color')->nullable();
            }

            if (!Schema::hasColumn('simple_products', 'sale_tag_text_color')) {
                $table->string('sale_tag_text_color')->nullable();
            }

        });

        Schema::table('report_products', function (Blueprint $table) {

            if (!Schema::hasColumn('report_products', 'simple_pro_id')) {
                $table->integer('simple_pro_id')->default(0);
            }
            
        });

        Schema::table('coupans', function (Blueprint $table) {

            if (!Schema::hasColumn('coupans', 'simple_pro_id')) {
                $table->integer('simple_pro_id')->nullable();
            }
            
        });

        Schema::table('shippings', function (Blueprint $table) {

            if (!Schema::hasColumn('shippings', 'whole_order')) {
                $table->integer('whole_order')->default(0)->unsigned();
            }
            
        });

        Schema::table('products', function (Blueprint $table) {

            if (!Schema::hasColumn('products', 'hsn')) {
                $table->string('hsn')->nullable();
            }

            if (!Schema::hasColumn('products', 'sale_tag')) {
                $table->string('sale_tag')->nullable();
            }

            if (!Schema::hasColumn('products', 'sale_tag_color')) {
                $table->string('sale_tag_color')->nullable();
            }

            if (!Schema::hasColumn('products', 'sale_tag_text_color')) {
                $table->string('sale_tag_text_color')->nullable();
            }
            
        });

        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'social_id')) {
                $table->string('social_id')->nullable();
            }
            
        });

        Schema::table('invoice_downloads', function (Blueprint $table) {

            if (!Schema::hasColumn('invoice_downloads', 'courier_channel')) {
                $table->string('courier_channel')->nullable();
            }

            if (!Schema::hasColumn('invoice_downloads', 'tracking_link')) {
                $table->longText('tracking_link')->nullable();
            }

            if (!Schema::hasColumn('invoice_downloads', 'exp_delivery_date')) {
                $table->timestamp('exp_delivery_date')->nullable();
            }

            if (!Schema::hasColumn('invoice_downloads', 'cashback')) {
                $table->double('cashback')->nullable();
            }
            
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
