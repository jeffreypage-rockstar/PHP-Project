<?php namespace App\Dubb\Repos;

use App\Dubb\Contracts\ListingInterface;
use App\Dubb\Exceptions\GenericException;
use App\Entities\Listing;
use App\Http\Requests\ListingCreate;
use App\Http\Requests\ListingGetAll;
use App\Entities\Addon;
use App\Http\Requests\ListingUpdate;
use Illuminate\Support\Facades\DB;

class EloquentListingRepository implements ListingInterface
{
    protected $db;
    protected $listing;
    protected $addon;

    public function __construct(DB $db, Listing $listing, Addon $addon)
    {
        $this->db = $db;
        $this->listing = $listing;
        $this->addon = $addon;
    }
    /**
     * @param ListingCreate $requestObj
     * @return mixed
     */
    public function create(ListingCreate $requestObj)
    {
        // Begin Transasction
        DB::beginTransaction();

        //Create the listing
        $listing = Listing::create($requestObj->all());
        $request = $requestObj->all();
        $addons = $request['addon'];


        // Save the upsells
        foreach($addons as $pricing) {
            $pricing['listing_id']=$listing->id;
            $this->addon->create($pricing);
        }

        DB::commit();

        return $listing;

    }

    /**
     * @param ListingGetAll $request
     * @return mixed
     */
    public function getAll(ListingGetAll $request)
    {
        return $this->listing->all()->load('user');
    }

    /**
     * @param $id
     * @return $this
     * @throws GenericException
     */
    public function get($id)
    {
        $listing = $this->listing->find($id);

        if (is_null($listing)) {
            throw new GenericException('Listing with ID:'.$id. ' not found.');
        }

        return $listing->load('user');
    }


    /**
     * @param $id
     * @return mixed
     * @throws GenericException
     */
    public function delete($id)
    {

        $deleted = $this->listing->destroy($id) > 0;

        if (! $deleted) {
            throw new GenericException('Listing with ID '. $id. ' not available.');
        }

        return $deleted;
    }

    /**
     * @param ListingUpdate $requestObj
     * @return mixed
     * @throws GenericException
     */
    public function update(ListingUpdate $requestObj)
    {
        $request = $requestObj->all();

        $listing = $this->listing->update($request);

        if (is_null($listing)) {
            throw new GenericException('Error connecting');
        }

    }
}