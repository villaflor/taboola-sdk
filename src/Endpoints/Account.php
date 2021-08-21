<?php

namespace Villaflor\TaboolaSDK\Endpoints;

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\Connection\APIInterface;
use Villaflor\Connection\Traits\BodyAccessorTrait;

class Account implements APIInterface
{
    use BodyAccessorTrait;

    private AdapterInterface $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAccountDetails(): \stdClass
    {
        $accountDetails = $this->adapter->get('users/current/account');
        $this->body = json_decode($accountDetails->getBody());

        return (object)['result' => $this->body];
    }
}
