<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimpleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('simple_products')){
            Schema::create('simple_products', function (Blueprint $table) {
                $table->id();
                $table->string('product_name');
                $table->string('slug');
                $table->longText('product_detail')->nullable();
                $table->integer('category_id')->unsigned();
                $table->longText('product_tags')->nullable();
                $table->double('price');
                $table->double('offer_price')->nullable();
                $table->double('tax')->nullable();
                $table->string('thumbnail');
                $table->string('hover_thumbnail');
                $table->longText('product_file');
                $table->integer('status')->default(0);
                $table->integer('stock')->default(0);
                $table->integer('store_id')->nullable();
                $table->integer('brand_id')->nullable();
                $table->integer('qty')->default(0)->nullable();
                $table->softDeletes();
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
    Schema::dropIfExists('simple_products');
    }
}
