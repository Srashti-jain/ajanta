<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAllcountryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('allcountry') ) {
			Schema::create('allcountry', function(Blueprint $table)
			{
				$table->increments('id');
				$table->char('iso', 2);
				$table->string('name', 80);
				$table->string('nicename', 80);
				$table->char('iso3', 3)->nullable();
				$table->smallInteger('numcode')->nullable();
				$table->integer('phonecode');
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
		Schema::drop('allcountry');
	}

}
