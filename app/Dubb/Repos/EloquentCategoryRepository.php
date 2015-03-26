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
     * @param GetCategories $requestObj
     * @return mixed
     * @throws GenericException
     */
    public function get($id, GetCategories $requestObj)
    {
        $category = $this->category;

        if (is_null($category)) {
            throw new GenericException('Category with ID:'.$id. ' not found.');
        }


        $category = $requestObj->loadRelatedModels($category);

        return $category->find($id);
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
     * @param $id
     * @param GetCategories $requestObj
     * @return mixed
     */
    public function getListingsByCategory($id, GetCategories $requestObj)
    {
       // $sql = "SELECT name, description FROM listing where category_id IN ( SELECT to_id FROM category_edges WHERE from_id={$id})"

        $cols = [
            'listings.name', 'listings.description', 'listings.lat', 'listings.long', 'listings.category_id',
            'listings.status', 'listings.created_at', 'users.username', 'users.first',
            'users.last', 'users.zip', 'users.city', 'users.country_code', 'users.country',
            'users.is_pro', 'users.seller_location_verified', 'users.verified',
            'users.response_time_hours', 'users.email'
        ];
        $category_ids =array_values($this->edges->where('from_id',$id)->get(['to_id'])->toArray());
        if ( ! in_array($id, ($category_ids))) {
            array_push($category_ids, $id);
        }
        $listings =  \DB::table('listings')
            ->join('users', 'listings.user_id', '=', 'users.id')
            ->whereIn('listings.category_id', $category_ids)
            ->select($cols);

        $listings = $requestObj->sortBy($listings);

        // Get the paginated result
        $listings = $requestObj->paginateResponse($listings);

        return $listings;
    }
}