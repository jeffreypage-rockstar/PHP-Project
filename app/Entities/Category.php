<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $fillable = ['name', 'description'];

	public function edges()
	{
		return $this->hasMany('App\Entities\CategoryEdges', 'from_id', 'id');
	}

	public function listing()
	{
		return $this->hasMany('App\Entities\Listing', 'category_id');
	}

	public function nestedlisting()
	{
		return $this->hasManyThrough('App\Entities\Listing', 'App\Entities\CategoryEdges', 'from_id', 'category_id');
	}
}
