<?php namespace Dubb\Contracts;

interface AuthInterface
{

    public function getOauthToken(Client $client);

}