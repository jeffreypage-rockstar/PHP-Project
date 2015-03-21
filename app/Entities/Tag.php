<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {


    public function user()
    {
        return $this->belongsTo('App\Entities\User');
    }

}
