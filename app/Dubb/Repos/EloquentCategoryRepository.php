<?php namespace App\Dubb\Repos;

use App\Entities\CategoryEdges;
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
    protected $edges;

    public function __construct(Category $category, CategoryEdges $edges)
    {
        $this->category = $category;
        $this->edges = $edges;
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

    /**
     * @param $request
     * @param bool $subcategories
     * @return mixed
     */
    public function getAllParentCategories(GetCategories $request, $subcategories = false)
    {
        $sql = "SELECT c.id,c.name,c.description from categories as c WHERE c.id IN (SELECT DISTINCT(from_id) FROM category_edges)";

        $parents = \DB::select(\DB::raw($sql));
        if ( ! $subcategories) {
            $pager = [
                'per_page' => (int) count($parents),
                'current_page' => 1,
                'next_page' =>null,
                'prev_page' => null,
                'from' => 1,
                'to' => count($parents)
            ];
            $items['paginator_data'] = $parents;
            $items['paginator'] = $pager;
            return $items;
        }

        $result = [];
        foreach($parents as $cat) {

           $sql_subcats = "SELECT id,name,description FROM categories " .
            "WHERE id in (select distinct(to_id) from category_edges " .
            "WHERE from_id={$cat->id} AND from_id <> to_id)";

            $cat->subcategories = \DB::select(\DB::raw($sql_subcats));

            array_push($result, $cat);
        }

        $pager = [
            'per_page' => (int) count($result),
            'current_page' => 1,
            'next_page' =>null,
            'prev_page' => null,
            'from' => 1,
            'to' => count($result)
        ];
        $items['paginator_data'] = $result;
        $items['paginator'] = $pager;
        return $items;
    }

    /**
     * @return mixed
     */
    public function getAllSubCategories()
    {

    }
}