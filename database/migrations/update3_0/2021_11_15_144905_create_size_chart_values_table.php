<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizeChartValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('size_chart_values')){

            Schema::create('size_chart_values', function (Blueprint $table) {
                $table->id();
                $table->string('value');

                $table->unsignedBigInteger('option_id');
                $table->foreign('option_id')->references('id')->on('size_chart_options');

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
        Schema::dropIfExists('size_chart_values');
    }
}
