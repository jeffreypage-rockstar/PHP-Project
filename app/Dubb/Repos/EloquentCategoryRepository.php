<?php namespace App\Dubb\Repos;

use App\Dubb\Contracts\CategoryInterface;
use App\Dubb\Exceptions\GenericException;
use App\Entities\Category;
use App\Http\Requests\CreateCategory;
use App\Http\Requests\GetCategories;
use App\Http\Requests\UpdateCategory;
use Illuminate\Support\Facades\DB;

class EloquentCategoryRepository implements CategoryInterface
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GenericException
     */
    public function get($id)
    {
        $category = $this->category->find($id);

        if (is_null($category)) {
            throw new GenericException('Category with ID:'.$id. ' not found.');
        }

        return $category;
    }

    /**
     * @param GetCategories $requestObj
     * @return mixed
     */
    public function getAll(GetCategories $requestObj)
    {
        // get listing module
        $category = $this->category;

        // if requesting related models add them
        $category = $requestObj->loadRelatedModels($category);

        // Get the paginated result
        $category = $requestObj->paginateResponse($category);

        return $category;
    }

    /**
     * @param CreateCategory $requestObj
     * @return mixed
     */
    public function create(CreateCategory $requestObj)
    {
        // Begin Transaction
        DB::beginTransaction();

        //Create the listing
        $category = $this->category->create($requestObj->all());

        DB::commit();

        return $category;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GenericException
     */
    public function delete($id)
    {
        $deleted = $this->category->destroy($id) > 0;

        if (! $deleted) {
            throw new GenericException('Category with ID '. $id. ' not available.');
        }

        return $deleted;
    }

    /**
     * @param UpdateCategory $requestObj
     * @return mixed
     * @throws GenericException
     */
    public function update(UpdateCategory $requestObj)
    {
        $request = $requestObj->all();
        $category = $this->category->find($request['id']);


        if (is_null($category)) {
            throw new GenericException('Error Updating Category');
        }

        foreach($request as $key=>$val) {
            $category->setAttribute($key, $val);
        }

        return $category->save();
    }
}