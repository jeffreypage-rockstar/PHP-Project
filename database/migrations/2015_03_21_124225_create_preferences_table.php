<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreferencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('preferences', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('key');
			$table->string('value');
			$table->timestamps();

			// indexs
			$table->index('key');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('preferences');
	}

}
