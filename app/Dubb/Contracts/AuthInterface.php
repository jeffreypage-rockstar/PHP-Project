<?php namespace App\Dubb\Contracts;

interface AuthInterface
{

    public function getOauthToken(Client $client);

    public function signUpIfNotExisting($request);
}