<?php

declare(strict_types=1);

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\TaboolaSDK\Configurations\Campaigns\AllCampaignsConfiguration;
use Villaflor\TaboolaSDK\Configurations\Campaigns\SingleCampaignConfiguration;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Endpoints\Campaigns;

beforeEach(function () {
    $this->adapter = Mockery::mock(AdapterInterface::class);
    $this->endpoint = new Campaigns($this->adapter);
    $this->accountId = 'demo-account-001';
});

afterEach(function () {
    Mockery::close();
});

it('can get all campaigns', function () {
    $config = new AllCampaignsConfiguration($this->accountId);

    $response = mockResponseFromFixture('Campaigns/all_campaigns.json');

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getAllCampaigns($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray()
        ->and($result->results)->toHaveCount(3);

    // Results contain stdClass objects
    $firstCampaign = $result->results[0];
    expect($firstCampaign)->toBeInstanceOf(stdClass::class)
        ->and($firstCampaign->id)->toBe('5750752')
        ->and($firstCampaign->name)->toBe('Demo Campaign 1')
        ->and($firstCampaign->cpc)->toBe(0.25);
});

it('can get single campaign', function () {
    $config = new SingleCampaignConfiguration($this->accountId, '5750752');

    $response = mockResponseFromFixture('Campaigns/single_campaign.json');

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getCampaign($config);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->id)->toBe('5750752')
        ->and($result->name)->toBe('Demo Campaign 1')
        ->and($result->cpc)->toBe(0.25)
        ->and($result->bid_strategy)->toBe('FIXED');
});

it('can create campaign', function () {
    $config = new SingleCampaignConfiguration($this->accountId, '');
    $campaignData = [
        'name' => 'New Test Campaign',
        'branding_text' => 'Test Brand',
        'cpc' => 0.50,
        'spending_limit' => 100.00,
    ];

    $response = mockResponseFromFixture('Campaigns/created_campaign.json');

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->withArgs(function ($uri, $options) use ($campaignData) {
            return isset($options['json']);
        })
        ->andReturn($response);

    $result = $this->endpoint->createCampaign($config, $campaignData);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->id)->toBe('1234567')
        ->and($result->name)->toBe('New Test Campaign')
        ->and($result->cpc)->toBe(0.50);
});

it('can update campaign', function () {
    $config = new SingleCampaignConfiguration($this->accountId, '123');
    $campaignData = ['name' => 'Updated Campaign'];

    $responseData = json_encode(['id' => '123', 'name' => 'Updated Campaign']);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->updateCampaign($config, $campaignData);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->name)->toBe('Updated Campaign');
});

it('can delete campaign', function () {
    $config = new SingleCampaignConfiguration($this->accountId, '123');

    $responseData = json_encode(['success' => true]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('delete')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->deleteCampaign($config);

    expect($result)->toBeInstanceOf(stdClass::class);
});

it('can duplicate campaign', function () {
    $config = new SingleCampaignConfiguration($this->accountId, '123');
    $duplicateData = ['name' => 'Duplicated Campaign'];

    $responseData = json_encode(['id' => '789', 'name' => 'Duplicated Campaign']);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->duplicateCampaign($config, $duplicateData);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->id)->toBe('789');
});

it('can bulk update campaigns', function () {
    $config = new AllCampaignsConfiguration($this->accountId);
    $campaigns = [
        ['id' => '5750752', 'cpc' => 0.60, 'spending_limit' => 150.00],
        ['id' => '5750753', 'cpc' => 0.55, 'spending_limit' => 200.00],
    ];

    $response = mockResponseFromFixture('Campaigns/bulk_updated_campaigns.json');

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->bulkUpdateCampaigns($config, $campaigns);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray()
        ->and($result->results)->toHaveCount(2);

    // Verify updated values (results contain stdClass objects)
    expect($result->results[0])->toBeInstanceOf(stdClass::class)
        ->and($result->results[0]->cpc)->toBe(0.60)
        ->and($result->results[1]->cpc)->toBe(0.55);
});
