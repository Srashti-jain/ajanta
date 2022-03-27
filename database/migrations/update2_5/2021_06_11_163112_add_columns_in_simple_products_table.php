<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInSimpleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('simple_products')) {

            Schema::table('simple_products', function (Blueprint $table) {

                if (!Schema::hasColumn('simple_products', 'actual_offer_price')) {
                    $table->double('actual_offer_price')->default(0);
                }

                if (!Schema::hasColumn('simple_products', 'actual_selling_price')) {
                    $table->double('actual_selling_price');
                }

                if (!Schema::hasColumn('simple_products', 'commission_rate')) {
                    $table->double('commission_rate')->default(0);
                }

                if (!Schema::hasColumn('simple_products', 'tax_rate')) {
                    $table->double('tax_rate')->default(0)->after('tax');
                }

                if (!Schema::hasColumn('simple_products', 'min_order_qty')) {
                    $table->integer('min_order_qty')->default(1)->after('stock');
                }

                if (!Schema::hasColumn('simple_products', 'max_order_qty')) {
                    $table->integer('max_order_qty')->default(1);
                }

                if (!Schema::hasColumn('simple_products', 'external_product_link')) {
                    $table->longText('external_product_link')->nullable();
                }

                if (!Schema::hasColumn('simple_products', 'subcategory_id')) {
                    $table->integer('subcategory_id')->unsigned()->nullable();
                }

                if (!Schema::hasColumn('simple_products', 'child_id')) {
                    $table->integer('child_id')->nullable()->unsigned();
                }

                if (!Schema::hasColumn('simple_products', 'free_shipping')) {
                    $table->integer('free_shipping')->unsigned();
                }

                if (!Schema::hasColumn('simple_products', 'featured')) {
                    $table->integer('featured')->unsigned()->default(0);
                }

                if (!Schema::hasColumn('simple_products', 'cancel_avbl')) {
                    $table->integer('cancel_avbl')->unsigned()->default(0);
                }

                if (!Schema::hasColumn('simple_products', 'cod_avbl')) {
                    $table->integer('cod_avbl')->unsigned()->default(0);
                }

                if (!Schema::hasColumn('simple_products', 'return_avbl')) {
                    $table->integer('return_avbl')->unsigned()->default(0);
                }

                if (!Schema::hasColumn('simple_products', 'policy_id')) {
                    $table->integer('policy_id')->nullable();
                }

                if (!Schema::hasColumn('simple_products', 'stock')) {
                    $table->integer('stock')->unsigned()->nullable();
                }

                if (!Schema::hasColumn('simple_products', 'type')) {
                    $table->string('type');
                }

                if (!Schema::hasColumn('simple_products', 'tax_name')) {
                    $table->string('tax_name');
                }

                if (!Schema::hasColumn('simple_products', 'key_features')) {
                    $table->longText('key_features')->nullable();
                }

                if (!Schema::hasColumn('simple_products', 'model_no')) {
                    $table->string('model_no')->nullable();
                }

                if (!Schema::hasColumn('simple_products', 'sku')) {
                    $table->string('sku')->nullable();
                }

                if (!Schema::hasColumn('simple_products', 'hsin')) {
                    $table->string('hsin')->nullable();
                }

            });

        }

        if (Schema::hasTable('comments')) {

            Schema::table('comments', function (Blueprint $table) {

                if (!Schema::hasColumn('comments', 'simple_pro_id')) {

                    $table->integer('simple_pro_id')->unsigned()->nullable();

                }

            });

        }

        if (Schema::hasTable('faq_products')) {

            Schema::table('faq_products', function (Blueprint $table) {

                if (!Schema::hasColumn('faq_products', 'simple_pro_id')) {

                    $table->integer('simple_pro_id')->unsigned()->default(0);

                }

            });

        }

        if (Schema::hasTable('product_specifications')) {

            Schema::table('product_specifications', function (Blueprint $table) {

                if (!Schema::hasColumn('product_specifications', 'simple_pro_id')) {

                    $table->integer('simple_pro_id')->unsigned()->default(0);

                }

            });

        }

        if (Schema::hasTable('user_reviews')) {

            Schema::table('user_reviews', function (Blueprint $table) {

                if (!Schema::hasColumn('user_reviews', 'simple_pro_id')) {

                    $table->integer('simple_pro_id')->unsigned()->nullable();

                }

            });

        }

        if (Schema::hasTable('carts')) {

            Schema::table('carts', function (Blueprint $table) {

                if (!Schema::hasColumn('carts', 'simple_pro_id')) {

                    $table->integer('simple_pro_id')->unsigned()->nullable();

                }

            });

        }

        if (Schema::hasTable('orders')) {

            Schema::table('orders', function (Blueprint $table) {

                if (!Schema::hasColumn('orders', 'simple_pro_ids')) {

                    $table->longText('simple_pro_ids')->nullable()->after('main_pro_id');

                }

            });

        }

        if (Schema::hasTable('invoice_downloads')) {

            Schema::table('invoice_downloads', function (Blueprint $table) {

                if (!Schema::hasColumn('invoice_downloads', 'simple_pro_id')) {

                    $table->integer('simple_pro_id')->unsigned()->nullable()->after('variant_id');

                }

            });

        }

        if (Schema::hasTable('order_activity_logs')) {

            Schema::table('order_activity_logs', function (Blueprint $table) {

                if (!Schema::hasColumn('order_activity_logs', 'simple_pro_id')) {

                    $table->integer('simple_pro_id')->unsigned()->nullable()->after('variant_id');

                }

            });

        }

        if (Schema::hasTable('wishlists')) {

            Schema::table('wishlists', function (Blueprint $table) {

                if (!Schema::hasColumn('wishlists', 'simple_pro_id')) {

                    $table->integer('simple_pro_id')->unsigned()->nullable()->after('pro_id');

                }

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
        Schema::table('simple_products', function (Blueprint $table) {
            //
        });
    }
}
