<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

    protected $table = 'tag';
    
    protected $fillable = ['name', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

}
