<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RenameTablesToSingular extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::rename('addons', 'addon');
		Schema::rename('assets', 'asset');
		Schema::rename('categories', 'category');
		Schema::rename('category_edges', 'category_edge');
		Schema::rename('preferences', 'preference');
		Schema::rename('tags', 'tag');
		Schema::rename('tokens', 'token');
		Schema::rename('users', 'user');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::rename('addon', 'addons');
		Schema::rename('asset', 'assets');
		Schema::rename('category', 'categories');
		Schema::rename('category_edge', 'category_edges');
		Schema::rename('preference', 'preferences');
		Schema::rename('tag', 'tags');
		Schema::rename('token', 'tokens');
		Schema::rename('user', 'users');
	}

}
