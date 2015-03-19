<?php namespace App\Dubb\Contracts;

use App\Http\Requests\ListingCreate;

interface ListingInterface {


    /**
     * @param ListingCreate $request
     * @return mixed
     */
    public function create(ListingCreate $request);
}