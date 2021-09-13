<?php

namespace Villaflor\TaboolaSDK\Endpoints;

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\Connection\APIInterface;
use Villaflor\Connection\Traits\BodyAccessorTrait;
use Villaflor\TaboolaSDK\Definitions\URI;

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
        $accountDetails = $this->adapter->get(URI::API_URI . 'users/current/account');

        $this->body = json_decode($accountDetails->getBody());

        return (object)['body' => $this->body];
    }

    public function getAdvertiserAccountsInNetwork(string $accountID): \stdClass
    {
        $accounts = $this->adapter->get(URI::API_URI . $accountID . '/advertisers');

        $this->body = json_decode($accounts->getBody());

        return (object)['results' => $this->body->results, 'metadata' => $this->body->metadata];
    }

    public function getAllowedAccounts(): \stdClass
    {
        $accounts = $this->adapter->get(URI::API_URI . 'users/current/allowed-accounts');

        $this->body = json_decode($accounts->getBody());

        return (object)['results' => $this->body->results, 'metadata' => $this->body->metadata];
    }
}
