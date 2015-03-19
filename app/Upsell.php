<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Upsell extends Model {

	public function listing()
    {
        return $this->belongsTo('Listing');
    }

}
