<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('chats')){
            Schema::create('chats', function (Blueprint $table) {
                $table->id();
                $table->longText('message')->nullable();

                $table->unsignedBigInteger('conv_id');
                $table->foreign('conv_id')->references('id')->on('conversations');

                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users');

                $table->string('type',100)->default('text');
                $table->string('media')->nullable();
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
        Schema::dropIfExists('chats');
    }
}
