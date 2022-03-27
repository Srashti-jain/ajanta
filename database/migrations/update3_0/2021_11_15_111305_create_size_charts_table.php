<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizeChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('size_charts')){
            
            Schema::create('size_charts', function (Blueprint $table) {
                $table->id();
                $table->string('template_name');
                $table->char('template_code',36);
                $table->integer('user_id')->unsigned();
                $table->integer('status')->unsigned()->default(0);
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
        Schema::dropIfExists('size_charts');
    }
}
