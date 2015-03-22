<?php namespace App\Dubb\Repos;

use App\Dubb\Contracts\AssetInterface;
use App\Dubb\Exceptions\GenericException;
use App\Entities\Asset;
use App\Http\Requests\CreateAsset;
use App\Http\Requests\GetAssets;
use App\Http\Requests\UpdateAsset;
use Illuminate\Support\Facades\DB;

class EloquentAssetRepository implements AssetInterface
{
    protected $asset;

    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GenericException
     */
    public function get($id)
    {
        $asset = $this->asset->find($id);

        if (is_null($asset)) {
            throw new GenericException('Asset with ID:'.$id. ' not found.');
        }

        return $asset;
    }

    /**
     * @param GetAssets $requestObj
     * @return mixed
     */
    public function getAll(GetAssets $requestObj)
    {
        // get listing module
        $asset = $this->asset;

        // if requesting related models add them
        $asset = $requestObj->loadRelatedModels($asset);

        // Get the paginated result
        $asset = $requestObj->paginateResponse($asset);

        return $asset;
    }

    /**
     * @param CreateAsset $requestObj
     * @return mixed
     */
    public function create(CreateAsset $requestObj)
    {
        // Begin Transaction
        DB::beginTransaction();

        //Create the listing
        $asset = $this->asset->create($requestObj->all());

        DB::commit();

        return $asset;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GenericException
     */
    public function delete($id)
    {
        $deleted = $this->asset->destroy($id) > 0;

        if (! $deleted) {
            throw new GenericException('Asset with ID '. $id. ' not available.');
        }

        return $deleted;
    }

    /**
     * @param UpdateAsset $requestObj
     * @return mixed
     * @throws GenericException
     */
    public function update(UpdateAsset $requestObj)
    {
        $request = $requestObj->all();
        $asset = $this->asset->find($request['id']);


        if (is_null($asset)) {
            throw new GenericException('Error Updating Asset');
        }

        foreach($request as $key=>$val) {
            $asset->setAttribute($key, $val);
        }

        return $asset->save();
    }
}