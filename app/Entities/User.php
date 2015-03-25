<?php namespace App\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'username', 'first', 'last', 'bio', 'zip', 'city', 'state', 'country_code',
		'country', 'phone', 'facebook_token', 'twitter_token', 'gplus_token', 'is_pro',
		'seller_location_verified', 'verified', 'response_time_hours', 'timezone', 'email',
		'password','is_admin', 'lat', 'long', 'remember_token'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function listing()
	{
		return $this->hasMany('App\Entities\Listing', 'user_id');
	}

}
