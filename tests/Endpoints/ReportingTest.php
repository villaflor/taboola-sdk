<?php

namespace Villaflor\TaboolaSDK\Tests\Endpoints;

use Villaflor\Connection\Auth\APIToken;
use Villaflor\TaboolaSDK\Configurations\Reporting\CampaignSummaryConfiguration;
use Villaflor\TaboolaSDK\Configurations\Reporting\TopCampaignContentConfiguration;
use Villaflor\TaboolaSDK\Definitions\CampaignSummaryDimensionDefinition;
use Villaflor\TaboolaSDK\Definitions\CampaignSummaryFilterDefinition;
use Villaflor\TaboolaSDK\Definitions\TopCampaignContentDimensionDefinition;
use Villaflor\TaboolaSDK\Definitions\TopCampaignContentFilterDefinition;
use Villaflor\TaboolaSDK\Endpoints\Reporting;
use Villaflor\TaboolaSDK\TaboolaClient;
use Villaflor\TaboolaSDK\Tests\TestCase;

class ReportingTest extends TestCase
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

    public function testCampaignSummaryReport()
    {
        $filter = [
            CampaignSummaryFilterDefinition::START_DATE => '2021-01-01',
            CampaignSummaryFilterDefinition::END_DATE => '2021-01-01',
        ];

        $config = new CampaignSummaryConfiguration(
            $this->accountID,
            CampaignSummaryDimensionDefinition::CAMPAIGN_DAY_BREAKDOWN,
            $filter
        );

        $this->assertEquals($this->accountID . "/reports/campaign-summary/dimensions/" . CampaignSummaryDimensionDefinition::CAMPAIGN_DAY_BREAKDOWN, $config->getPath());
        $this->assertEquals($filter, $config->getArray());

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Reporting/campaignSummaryReport.json');

        $this->mock->method('get')->willReturn($response);
        $this->mock->expects($this->once())->method('get');

        $reporting = new Reporting($this->mock);

        $result = $reporting->getCampaignSummaryReport($config);

        $this->assertObjectHasAttribute('results', $result);
        $this->assertObjectHasAttribute('metadata', $result);
        $this->assertObjectHasAttribute('timezone', $result);
        $this->assertObjectHasAttribute('recordCount', $result);

        $this->assertEquals(154, $result->results[0]->impressions);
        $this->assertEquals(9, $result->recordCount);

        $this->assertEquals(154, $reporting->getBody()->results[0]->impressions);
        $this->assertEquals(9, $reporting->getBody()->recordCount);
    }

    public function testTopCampaignContentReport()
    {
        $filter = [
            TopCampaignContentFilterDefinition::START_DATE => '2021-01-01',
            TopCampaignContentFilterDefinition::END_DATE => '2021-01-01',
        ];

        $config = new TopCampaignContentConfiguration(
            $this->accountID,
            TopCampaignContentDimensionDefinition::ITEM_BREAKDOWN,
            $filter
        );

        $this->assertEquals($this->accountID . "/reports/top-campaign-content/dimensions/" . TopCampaignContentDimensionDefinition::ITEM_BREAKDOWN, $config->getPath());
        $this->assertEquals($filter, $config->getArray());

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Reporting/topCampaignContentReport.json');

        $this->mock->method('get')->willReturn($response);
        $this->mock->expects($this->once())->method('get');

        $reporting = new Reporting($this->mock);

        $result = $reporting->getTopCampaignContentReport($config);

        $this->assertObjectHasAttribute('results', $result);
        $this->assertObjectHasAttribute('metadata', $result);
        $this->assertObjectHasAttribute('timezone', $result);
        $this->assertObjectHasAttribute('recordCount', $result);

        $this->assertEquals('12345678', $result->results[0]->item);
        $this->assertEquals(23, $result->recordCount);

        $this->assertEquals('12345678', $reporting->getBody()->results[0]->item);
        $this->assertEquals(23, $reporting->getBody()->recordCount);
    }
}
