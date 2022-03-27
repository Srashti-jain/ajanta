<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRMASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('r_m_a_s')){

            Schema::create('r_m_a_s', function (Blueprint $table) {

                $table->id();
                $table->longText('reason');
                $table->integer('status')->default(0)->unsigned();
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
        Schema::dropIfExists('r_m_a_s');
    }
}
