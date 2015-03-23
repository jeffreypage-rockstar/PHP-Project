<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryEdges extends Model {


    public function parent()
    {
        return $this->belongsTo('App\Entities\Category', 'from_id');
    }

    public function child()
    {
        return $this->belongsTo('App\Entities\Category', 'to_id');
    }

}
