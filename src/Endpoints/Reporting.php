<?php

namespace Villaflor\TaboolaSDK\Endpoints;

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\Connection\APIInterface;
use Villaflor\Connection\Traits\BodyAccessorTrait;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

class Reporting implements APIInterface
{
    use BodyAccessorTrait;

    private AdapterInterface $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getCampaignSummaryReport(PathConfigurationInterface $configuration): \stdClass
    {
        $report = $this->adapter->get(URI::API_URI . $configuration->getPath(), $configuration->getArray());

        $this->body = json_decode($report->getBody());

        return (object)[
            'timezone' => $this->body->timezone,
            'results' => $this->body->results,
            'recordCount' => $this->body->recordCount,
            'metadata' => $this->body->metadata,
        ];
    }
}
