<?php namespace App\Dubb\Contracts;

use App\Http\Requests\CreateAsset;
use App\Http\Requests\GetAssets;
use App\Http\Requests\UpdateAsset;

interface AssetInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function get($id);

    /**
     * @param GetAssets $request
     * @return mixed
     */
    public function getAll(GetAssets $request);

    /**
     * @param CreateAsset $request
     * @return mixed
     */
    public function create(CreateAsset $request);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param UpdateAsset $request
     * @return mixed
     */
    public function update(UpdateAsset $request);
}