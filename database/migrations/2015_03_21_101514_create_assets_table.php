<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('assets', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('object');
			$table->integer('object_id');
			$table->string('name');
			$table->string('url');
			$table->enum('type', ['image', 'video', 'file', 'audio', 'other']);
			$table->timestamps();

			//indexs
			$table->index('name');
			$table->index(['object', 'object_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('assets');
	}

}
