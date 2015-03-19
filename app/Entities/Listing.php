<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model {

    protected $fillable = [
        'name', 'description', 'category_id', 'user_id', 'lat', 'long', 'status'
    ];

	public function upsell()
    {
        return $this->hasMany('Upsell');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

}
