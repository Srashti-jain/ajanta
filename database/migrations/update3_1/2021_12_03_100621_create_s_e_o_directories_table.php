<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSEODirectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('s_e_o_directories')){
            Schema::create('s_e_o_directories', function (Blueprint $table) {
                
                $table->id();
                $table->string('city');
                $table->longText('detail');
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
        Schema::dropIfExists('s_e_o_directories');
    }
}
