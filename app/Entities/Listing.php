<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model {

    protected $table = 'listing';

    protected $fillable = [
        'name', 'description', 'category_id', 'user_id', 'lat', 'long', 'status', 'instructions', 'radius_mi',
        'radius_km'
    ];

	public function addon()
    {
        return $this->hasMany('App\Entities\Addon')->select(['id', 'description', 'price', 'listing_id', 'sequence']);
    }

    public function user()
    {
        return $this->belongsTo('App\Entities\User', 'user_id')->select(['id', 'email', 'first', 'last', 'is_pro', 'verified', 'seller_location_verified']);
    }

    public function category()
    {
        return $this->belongsTo('App\Entities\Category', 'category_id');
    }
}
