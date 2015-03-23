<?php namespace App\Dubb\Contracts;

use App\Http\Requests\CreateCategory;
use App\Http\Requests\GetCategories;
use App\Http\Requests\UpdateCategory;

interface CategoryInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function get($id);

    /**
     * @param GetCategories $request
     * @return mixed
     */
    public function getAll(GetCategories $request);

    /**
     * @param CreateCategory $request
     * @return mixed
     */
    public function create(CreateCategory $request);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param UpdateCategory $request
     * @return mixed
     */
    public function update(UpdateCategory $request);

    /**
     * @param GetCategories $request
     * @param bool $subcategories
     * @return mixed
     */
    public function getAllParentCategories(GetCategories $request, $subcategories = false);

    /**
     * @param $id
     * @param GetCategories $request
     * @return mixed
     */
    public function getListingsByCategory($id, GetCategories $request);


}