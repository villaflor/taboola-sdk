<?php

namespace Villaflor\TaboolaSDK\Tests\Endpoints;

use Villaflor\Connection\Auth\APIToken;
use Villaflor\TaboolaSDK\Configurations\Reporting\CampaignSummaryConfiguration;
use Villaflor\TaboolaSDK\Definitions\CampaignSummaryDimensionDefinition;
use Villaflor\TaboolaSDK\Definitions\CampaignSummaryFilterDefinition;
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
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Reporting/campaignSummaryReport.json');

        $this->mock->method('get')->willReturn($response);
        $this->mock->expects($this->once())->method('get');

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

        $reporting = new Reporting($this->mock);

        $result = $reporting->getCampaignSummaryReport($config);

        $this->assertObjectHasAttribute('results', $result);
        $this->assertObjectHasAttribute('metadata', $result);
        $this->assertObjectHasAttribute('timezone', $result);
        $this->assertObjectHasAttribute('recordCount', $result);
    }
}
