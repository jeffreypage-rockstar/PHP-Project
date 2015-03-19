<?php namespace App\Dubb\Contracts;

use App\Http\Requests\Request;
use App\Http\Requests\SignIn;
use App\Http\Requests\SignUp;

interface AuthInterface
{

    /**
     * @param Client $client
     * @return mixed
     */
    public function getOauthToken(Client $client);

    /**
     * @param Request|SignUp $request
     * @return mixed
     */
    public function signUpIfNotExisting(SignUp $request);

    /**
     * @param Request|SignIn $request
     * @return mixed
     */
    public function authenticate(SignIn $request);
}