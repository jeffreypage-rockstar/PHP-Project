<?php namespace App\Dubb\Repos;

use App\Dubb\Contracts\ListingInterface;
use App\Dubb\Exceptions\GenericException;
use App\Entities\Listing;
use App\Http\Requests\ListingCreate;
use App\Http\Requests\ListingGetAll;
use App\Entities\Upsell;
use App\Http\Requests\ListingUpdate;
use Illuminate\Support\Facades\DB;

class EloquentListingRepository implements ListingInterface
{
    protected $db;
    protected $listing;

    public function __construct(DB $db, Listing $listing)
    {
        $this->db = $db;
        $this->listing = $listing;
    }
    /**
     * @param ListingCreate $request
     * @return mixed
     */
    public function create(ListingCreate $request)
    {
        // Begin Transasction
        DB::beginTransaction();

        //Create the listing
        $listing = Listing::create($request->all());

        $upsell = $request->get('upsell');


        // Save the upsells
        foreach($upsell as $pricing) {
            $pricing['listing_id']=$listing->id;
            $price = Upsell::create($pricing);
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
     * @param ListingUpdate $request
     * @return mixed
     */
    public function update(ListingUpdate $request)
    {
        // TODO: Implement update() method.
    }
}