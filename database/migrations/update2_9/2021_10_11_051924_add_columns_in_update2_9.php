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
        Schema::table('stores',function(Blueprint $table){

            if (!Schema::hasColumn('stores', 'show_google_reviews')) {
                $table->integer('show_google_reviews')->unsigned()->default(0);
            }

            if (!Schema::hasColumn('stores', 'google_place_id')) {
                $table->string('google_place_id')->nullable();
            }

            if (!Schema::hasColumn('stores', 'google_place_api_key')) {
                $table->string('google_place_api_key')->nullable();
            }

        });

        Schema::table('simple_products',function(Blueprint $table){

            if (!Schema::hasColumn('simple_products', 'pre_order')) {
                $table->integer('pre_order')->unsigned()->default(0);
            }

            if (!Schema::hasColumn('simple_products', 'preorder_type')) {
                $table->integer('preorder_type')->nullable();
            }

            if (!Schema::hasColumn('simple_products', 'partial_payment_per')) {
                $table->double('partial_payment_per')->nullable();
            }

            if (!Schema::hasColumn('simple_products', 'product_avbl_date')) {
                $table->timestamp('product_avbl_date')->nullable();
            }
            
        });

        Schema::table('invoice_downloads',function(Blueprint $table){

            if (!Schema::hasColumn('invoice_downloads', 'type')) {
                $table->string('type')->nullable();
            }

            if (!Schema::hasColumn('invoice_downloads', 'remaning_amount')) {
                $table->double('remaning_amount')->default(0);
            }

            if (!Schema::hasColumn('invoice_downloads', 'rem_tax_amount')) {
                $table->double('rem_tax_amount')->default(0);
            }

        });

    }
};
