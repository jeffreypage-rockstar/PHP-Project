<?php namespace App\Dubb\Repos;

use App\Dubb\Contracts\UserInterface;
use App\Entities\User;
use App\Http\Requests\GetUsers;
use App\Http\Requests\UpdateUser;

class EloquentUserRepository implements UserInterface
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {

    }

    /**
     * @param GetUsers $requestObj
     * @return mixed
     */
    public function getAll(GetUsers $requestObj)
    {
        $request = $requestObj->all();

        // get listing module
        $user = $this->user;

        // if requesting related models add them
        $user = $requestObj->loadRelatedModels($user);

        // Get the paginated result
        $user = $requestObj->paginateResponse($user);

        return $user;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param UpdateUser $request
     * @return mixed
     */
    public function update(UpdateUser $request)
    {
        // TODO: Implement update() method.
    }
}