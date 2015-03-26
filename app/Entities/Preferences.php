<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Preferences extends Model {

    protected $table = 'preference';

    protected $fillable = [
        'user_id', 'key', 'value'
    ];

    protected $hidden = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Entities\User');

    }
}
