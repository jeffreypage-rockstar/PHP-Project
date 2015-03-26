<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ListingTagPivot extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('listing_tag', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('listing_id');
			$table->integer('tag_id');

//			$table->foreign('listing_id')
//				->references('id')->on('listings')
//				->onDelete('cascade');
//
//			$table->foreign('tag_id')
//				->references('id')->on('tags')
//				->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('listing_tag');
	}

}
