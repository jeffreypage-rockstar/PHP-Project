<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $fillable = ['name', 'description'];

	public function edges()
	{
		return $this->hasMany('App\Entities\CategoryEdges', 'from_id', 'id');
	}

}
