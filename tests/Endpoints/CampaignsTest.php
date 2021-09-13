<?php

namespace Villaflor\TaboolaSDK\Tests\Endpoints;

use Villaflor\Connection\Auth\APIToken;
use Villaflor\TaboolaSDK\Configurations\Campaigns\AllCampaignsConfiguration;
use Villaflor\TaboolaSDK\Definitions\AllCampaignsFilterDefinition;
use Villaflor\TaboolaSDK\Endpoints\Campaigns;
use Villaflor\TaboolaSDK\TaboolaClient;
use Villaflor\TaboolaSDK\Tests\TestCase;

class CampaignsTest extends TestCase
{
    private $mock;

    protected function setUp(): void
    {
        $this->mock = $this->getMockBuilder(TaboolaClient::class)
            ->setConstructorArgs([
                new APIToken('CZ0OAAAAAAAAEdt7AgAAAAAAGAEgAClebYBnbQEAADooMDMyMDg2MmExZWNlYjIyYWJhMjc1OGI4NzJlMGZhNWI5ZDYxN2Q0YkAC::644420::78997c')
            ])
            ->getMock();
    }

    public function testGetAllCampaigns()
    {
        $filter = [
            AllCampaignsFilterDefinition::FETCH_LEVEL => AllCampaignsFilterDefinition::FETCH_LEVEL_RECENT_AND_PAUSED_OPTIONS
        ];

        $config = new AllCampaignsConfiguration($this->accountID, $filter);

        $this->assertEquals($this->accountID . "/campaigns", $config->getPath());
        $this->assertEquals($filter, $config->getArray());

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Campaigns/getAllCampaigns.json');

        $this->mock->method('get')->willReturn($response);
        $this->mock->expects($this->once())->method('get');

        $campaigns = new Campaigns($this->mock);

        $result = $campaigns->getAllCampaigns($config);

        $this->assertObjectHasAttribute('results', $result);
        $this->assertObjectHasAttribute('metadata', $result);

        $this->assertEquals('5750752', $result->results[0]->id);
        $this->assertEquals('5750753', $result->results[1]->id);

        $this->assertEquals('5750752', $campaigns->getBody()->results[0]->id);
        $this->assertEquals('5750753', $campaigns->getBody()->results[1]->id);
    }
}
