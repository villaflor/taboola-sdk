<?php

namespace Villaflor\TaboolaSDK\Endpoints;

use stdClass;
use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\Connection\APIInterface;
use Villaflor\Connection\Traits\BodyAccessorTrait;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

class Account implements APIInterface
{
    use BodyAccessorTrait;

    private AdapterInterface $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAccountDetails(PathConfigurationInterface $configuration): stdClass
    {
        $this->getAccount($configuration);

        return (object)['body' => $this->body];
    }

    public function getAdvertiserAccountsInNetwork(PathConfigurationInterface $configuration): stdClass
    {
        $this->getAccount($configuration);

        return (object)['results' => $this->body->results, 'metadata' => $this->body->metadata];
    }

    public function getAllowedAccounts(PathConfigurationInterface $configuration): stdClass
    {
        $this->getAccount($configuration);

        return (object)['results' => $this->body->results, 'metadata' => $this->body->metadata];
    }

    private function getAccount(PathConfigurationInterface $configuration): void
    {
        $accounts = $this->adapter->get(URI::API_URI . $configuration->getPath());

        $this->body = json_decode($accounts->getBody());
    }
}
