<?php namespace App\Dubb\Contracts;

use App\Http\Requests\CreateTag;
use App\Http\Requests\GetTags;
use App\Http\Requests\UpdateTag;

interface TagInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function get($id);

    /**
     * @param GetTags $request
     * @return mixed
     */
    public function getAll(GetTags $request);

    /**
     * @param CreateTag $request
     * @return mixed
     */
    public function create(CreateTag $request);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param UpdateTag $request
     * @return mixed
     */
    public function update(UpdateTag $request);
}