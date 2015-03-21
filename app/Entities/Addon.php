<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model {

    protected $fillable = ['price', 'description', 'listing_id'];
	public function listing()
    {
        return $this->belongsTo('Listing');
    }

}
