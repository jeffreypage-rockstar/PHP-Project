<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model {

	protected $fillable = ['object', 'object_id', 'name', 'url', 'type'];

}
