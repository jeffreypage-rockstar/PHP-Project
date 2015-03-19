<?php namespace App\Dubb\Contracts;

use App\Entities\Listing;
use App\Http\Requests\ListingCreate;
use App\Http\Requests\ListingGetAll;

interface ListingInterface {


    /**
     * @param ListingCreate $request
     * @return mixed
     */
    public function create(ListingCreate $request);

    /**
     * @param ListingGetAll $request
     * @return mixed
     * @internal param Listing $listing
     */
    public function getAll(ListingGetAll $request);
}