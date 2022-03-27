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
       
        Schema::table('hotdeals', function (Blueprint $table) {

            if (!Schema::hasColumn('hotdeals', 'simple_pro_id')) {
                $table->integer('simple_pro_id')->default(0);
            }
            
        });

        Schema::table('special_offers', function (Blueprint $table) {

            if (!Schema::hasColumn('special_offers', 'simple_pro_id')) {
                $table->integer('simple_pro_id')->default(0);
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
