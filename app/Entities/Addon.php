<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model {

    protected $table = 'addon';
    
    protected $fillable = ['price', 'description', 'listing_id', 'sequence'];

    protected $hidden = ['listing_id'];

	public function listing()
    {
        return $this->belongsTo('Listing');
    }

}
