<?php namespace App\Dubb\Repos;

use App\Dubb\Contracts\ListingInterface;
use App\Dubb\Exceptions\GenericException;
use App\Entities\Listing;
use App\Http\Requests\GetUsers;
use App\Http\Requests\ListingCreate;
use App\Http\Requests\ListingGetAll;
use App\Entities\Addon;
use App\Http\Requests\ListingGetOne;
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
        $request = $this->converterMiKm($request);
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
     * @param ListingGetOne $requestObj
     * @return $this
     * @throws GenericException
     */
    public function get($id, ListingGetOne $requestObj)
    {
        $listing = $this->listing;

        if (is_null($listing)) {
            throw new GenericException('Listing with ID:'.$id. ' not found.');
        }


        $listing = $requestObj->loadRelatedModels($listing);

        return $listing->find($id);
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

        $request = $this->converterMiKm($request);

        $listing = $this->listing->find($request['id']);

        if (is_null($listing)) {
            throw new GenericException('Error Updating Listing');
        }

        foreach($request as $key=>$val) {
            if ($key == 'addon') {
                foreach($val as $addon_row) {

                    if (isset($addon_row['delete']) && $addon_row['delete'] && isset($addon_row['id'])) {
                        $addon = $this->addon->destroy($addon_row['id']);

                        if ($addon > 0 ) { continue;}
                    }else {
                        $addon_row['listing_id'] = $request['id'];
                        $this->addon->updateOrCreate($addon_row);
                    }
                }
                continue;
            }

            $listing->setAttribute($key, $val);
        }



        return $listing->save();
    }

    /**
     * @param $request
     * @return mixed
     */
    protected function converterMiKm($request)
    {
        if (isset($request['radius_mi'])) {
            $request['radius_km'] = (double)$request['radius_mi'] / 0.62137;
        }

        if (isset($request['radius_km'])) {
            $request['radius_mi'] = (double)$request['radius_km'] * 0.62137;
            return $request;
        }
        return $request;
    }

}