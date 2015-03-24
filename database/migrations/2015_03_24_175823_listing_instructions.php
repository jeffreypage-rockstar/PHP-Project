<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ListingInstructions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('listings', function($table)
		{
			$table->text('instructions')->after('description');
			$table->string('radius_mi')->after('long');
			$table->string('radius_km')->after('long');
		});

		Schema::table('addons', function($table)
		{
			$table->integer('sequence')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('listings', function($table)
		{
			$table->dropColumns(['instructions','radius_mi', 'radius_km']);
		});

		Schema::table('addons', function($table)
		{
			$table->dropColumns(['sequence']);
		});
	}

}
