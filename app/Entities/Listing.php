<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model {

	public function upsell()
    {
        return $this->hasMany('Upsell');
    }

}
