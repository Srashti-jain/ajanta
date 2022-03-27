<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('conversations')){

            Schema::create('conversations', function (Blueprint $table) {
                $table->id();
                $table->char('conv_id',36);

                $table->unsignedBigInteger('receiver_id');
                $table->foreign('receiver_id')->references('id')->on('users');

                $table->unsignedBigInteger('sender_id');
                $table->foreign('sender_id')->references('id')->on('users');
                
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
        Schema::dropIfExists('conversations');
    }
}
