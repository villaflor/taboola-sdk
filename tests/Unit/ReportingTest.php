<?php

declare(strict_types=1);

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\TaboolaSDK\Configurations\Reporting\CampaignSummaryConfiguration;
use Villaflor\TaboolaSDK\Configurations\Reporting\TopCampaignContentConfiguration;
use Villaflor\TaboolaSDK\Definitions\CampaignSummaryDimensionDefinition;
use Villaflor\TaboolaSDK\Definitions\TopCampaignContentDimensionDefinition;
use Villaflor\TaboolaSDK\DTO\ReportResponse;
use Villaflor\TaboolaSDK\Endpoints\Reporting;

beforeEach(function () {
    $this->adapter = Mockery::mock(AdapterInterface::class);
    $this->endpoint = new Reporting($this->adapter);
    $this->accountId = 'demo-account-001';
});

afterEach(function () {
    Mockery::close();
});

it('can get campaign summary report', function () {
    $config = new CampaignSummaryConfiguration(
        $this->accountId,
        CampaignSummaryDimensionDefinition::CAMPAIGN_DAY_BREAKDOWN,
        ['start_date' => '2024-01-01', 'end_date' => '2024-01-31']
    );

    $responseData = json_encode([
        'results' => [['date' => '2024-01-01', 'clicks' => 100]],
        'timezone' => 'UTC',
        'record_count' => 1,
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getCampaignSummaryReport($config);

    expect($result)->toBeInstanceOf(ReportResponse::class)
        ->and($result->results)->toBeArray()
        ->and($result->timezone)->toBe('UTC');
});

it('can get top campaign content report', function () {
    $config = new TopCampaignContentConfiguration(
        $this->accountId,
        TopCampaignContentDimensionDefinition::ITEM_BREAKDOWN,
        ['start_date' => '2024-01-01', 'end_date' => '2024-01-31']
    );

    $responseData = json_encode([
        'results' => [['item_id' => '123', 'clicks' => 500]],
        'timezone' => 'UTC',
        'record_count' => 1,
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getTopCampaignContentReport($config);

    expect($result)->toBeInstanceOf(ReportResponse::class)
        ->and($result->results)->toBeArray();
});

it('can get realtime campaign report', function () {
    $config = new CampaignSummaryConfiguration(
        $this->accountId,
        CampaignSummaryDimensionDefinition::CAMPAIGN_DAY_BREAKDOWN
    );

    $responseData = json_encode([
        'results' => [['campaign_id' => '456', 'impressions' => 1000]],
        'timezone' => 'UTC',
        'record_count' => 1,
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getRealtimeCampaignReport($config);

    expect($result)->toBeInstanceOf(ReportResponse::class);
});

it('can get realtime ads report', function () {
    $config = new TopCampaignContentConfiguration(
        $this->accountId,
        TopCampaignContentDimensionDefinition::ITEM_BREAKDOWN
    );

    $responseData = json_encode([
        'results' => [['item_id' => '789', 'ctr' => 0.05]],
        'timezone' => 'UTC',
        'record_count' => 1,
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getRealtimeAdsReport($config);

    expect($result)->toBeInstanceOf(ReportResponse::class);
});
