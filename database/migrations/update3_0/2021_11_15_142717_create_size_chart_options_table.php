<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizeChartOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('size_chart_options')){
            Schema::create('size_chart_options', function (Blueprint $table) {
                
                $table->id();
                $table->string('option')->nullable();

                $table->unsignedBigInteger('size_id');
                $table->foreign('size_id')->references('id')->on('size_charts');

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
        Schema::dropIfExists('size_chart_options');
    }
}
