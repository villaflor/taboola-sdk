<?php

namespace Villaflor\TaboolaSDK\Endpoints;

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\Connection\APIInterface;
use Villaflor\Connection\Traits\BodyAccessorTrait;
use Villaflor\TaboolaSDK\Variables;

class Campaigns implements APIInterface
{
    use BodyAccessorTrait;

    private AdapterInterface $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAllCampaigns(string $accountID): \stdClass
    {
        $campaigns = $this->adapter->get(Variables::API_URI . $accountID . '/campaigns');

        $this->body = json_decode($campaigns->getBody());

        return (object)['results' => $this->body->results, 'metadata' => $this->body->metadata];
    }
}
