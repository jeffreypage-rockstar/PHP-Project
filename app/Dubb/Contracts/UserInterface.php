<?php namespace App\Dubb\Contracts;

use App\Http\Requests\GetUsers;
use App\Http\Requests\UpdateUser;

interface UserInterface
{

    /**
     * @param $id
     * @param GetUsers $request
     * @return mixed
     */
    public function get($id, GetUsers $request);

    /**
     * @param GetUsers $request
     * @return mixed
     */
    public function getAll(GetUsers $request);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param UpdateUser $request
     * @return mixed
     */
    public function update(UpdateUser $request);

}