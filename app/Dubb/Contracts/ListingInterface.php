<?php namespace App\Dubb\Contracts;

use App\Entities\Listing;
use App\Http\Requests\ListingCreate;
use App\Http\Requests\ListingGetAll;
use App\Http\Requests\ListingGetOne;
use App\Http\Requests\ListingUpdate;

interface ListingInterface {


    /**
     * @param ListingCreate $requestObj
     * @return mixed
     */
    public function create(ListingCreate $requestObj);

    /**
     * @param ListingGetAll $request
     * @return mixed
     * @internal param Listing $listing
     */
    public function getAll(ListingGetAll $request);

    /**
     * @param $id
     * @return mixed
     */
    public function get($id);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param ListingUpdate $request
     * @return mixed
     */
    public function update(ListingUpdate $request);
}