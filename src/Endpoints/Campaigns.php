<?php

namespace Villaflor\TaboolaSDK\Endpoints;

use stdClass;
use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\Connection\APIInterface;
use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\Connection\Traits\BodyAccessorTrait;
use Villaflor\TaboolaSDK\Definitions\URI;

class Campaigns implements APIInterface
{
    use BodyAccessorTrait;

    private AdapterInterface $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAllCampaigns(ConfigurationsInterface $configurations): stdClass
    {
        $this->getCampaigns($configurations);

        return (object)['results' => $this->body->results, 'metadata' => $this->body->metadata];
    }

    private function getCampaigns(ConfigurationsInterface $configurations): void
    {
        $campaigns = $this->adapter->get(URI::API_URI . $configurations->getPath(), $configurations->getArray());

        $this->body = json_decode($campaigns->getBody());
    }
}
