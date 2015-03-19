<?php namespace App\Dubb\Repos;

use App\Dubb\Contracts\ListingInterface;
use App\Entities\Listing;
use App\Http\Requests\ListingCreate;
use App\Upsell;
use Illuminate\Support\Facades\DB;

class EloquentListingRepository implements ListingInterface
{
    protected $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
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
}