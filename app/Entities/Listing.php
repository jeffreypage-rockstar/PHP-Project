<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model {

    protected $fillable = [
        'name', 'description', 'category_id', 'user_id', 'lat', 'long', 'status'
    ];

	public function upsell()
    {
        return $this->hasMany('Addon');
    }

    public function user()
    {
        return $this->belongsTo('App\Entities\User', 'user_id')->select(['id', 'email', 'first', 'last', 'is_pro', 'verified', 'seller_location_verified']);
    }

}
