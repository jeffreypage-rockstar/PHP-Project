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
     * @param ListingGetAll $requestObj
     * @return mixed
     */
    public function getAll(ListingGetAll $requestObj)
    {
        $request = $requestObj->all();

        // get listing module
        $listing = $this->listing;

        // if requesting related models add them
        $listing = $requestObj->loadRelatedModels($listing);

        // Get the paginated result
        $listing = $requestObj->paginateResponse($listing);

        return $listing;
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
        $listing = $this->listing->find($requestObj->getId());

        if (is_null($listing)) {
            throw new GenericException('Error Updating Listing');
        }

        foreach($request as $key=>$val) {
            if ($key == 'addon') {
                foreach($val as $addon_row) {
                    $addon_row['listing_id'] = $requestObj->getId();
                    $addon = $this->addon->find($addon_row['id']);
                    if (is_null($addon)) {
                        throw new GenericException('Invalid addon ID: ' . $addon_row['id']);
                    }

                    $addon->update($addon_row);
                }
                continue;
            }

            $listing->setAttribute($key, $val);
        }



        return $listing->save();
    }

}