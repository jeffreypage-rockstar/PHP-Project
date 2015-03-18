<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('first')->nullable();
			$table->string('last')->nullable();
			$table->text('bio')->nullable();
			$table->string('zip')->nullable();
			$table->string('city')->nullable();
			$table->string('state');
			$table->string('country_code')->nullable();
			$table->string('country')->nullable();
			$table->string('phone')->nullable();
			$table->string('facebook_token')->nullable();
			$table->string('gplus_token')->nullable();
			$table->string('twitter_token')->nullable();
			$table->boolean('is_pro')->default(false);
			$table->boolean('seller_location_verified')->default(false);
			$table->boolean('verified')->default(false);
			$table->decimal('response_time_hours')->default(0.00);
			$table->string('timezone')->nullable();
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->boolean('is_admin')->default(false);
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
