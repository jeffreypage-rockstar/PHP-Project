<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Upsell extends Model {

    protected $fillable = ['price', 'description', 'listing_id'];
	public function listing()
    {
        return $this->belongsTo('Listing');
    }

}
