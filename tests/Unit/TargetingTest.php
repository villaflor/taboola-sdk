<?php

declare(strict_types=1);

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\TaboolaSDK\Configurations\Targeting\BlockedPublishersConfiguration;
use Villaflor\TaboolaSDK\Configurations\Targeting\CampaignTargetingConfiguration;
use Villaflor\TaboolaSDK\Configurations\Targeting\PublishersConfiguration;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Endpoints\Targeting;

beforeEach(function () {
    $this->adapter = Mockery::mock(AdapterInterface::class);
    $this->endpoint = new Targeting($this->adapter);
    $this->accountId = 'demo-account-001';
    $this->campaignId = 'campaign-123';
});

afterEach(function () {
    Mockery::close();
});

it('can get publishers', function () {
    $config = new PublishersConfiguration($this->accountId);

    $responseData = json_encode([
        'results' => [
            ['id' => 'pub-1', 'name' => 'Publisher 1'],
            ['id' => 'pub-2', 'name' => 'Publisher 2'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getPublishers($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray();
});

it('can get blocked publishers', function () {
    $config = new BlockedPublishersConfiguration($this->accountId);

    $responseData = json_encode([
        'results' => [
            ['id' => 'pub-3', 'name' => 'Blocked Publisher'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getBlockedPublishers($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class);
});

it('can update blocked publishers', function () {
    $config = new BlockedPublishersConfiguration($this->accountId);
    $blockedPublishers = ['publishers' => ['pub-3', 'pub-4']];

    $responseData = json_encode(['success' => true]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('put')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->updateBlockedPublishers($config, $blockedPublishers);

    expect($result)->toBeInstanceOf(stdClass::class);
});

it('can get postal code targeting', function () {
    $config = new CampaignTargetingConfiguration($this->accountId, $this->campaignId);

    $responseData = json_encode([
        'results' => [
            ['code' => '90001'],
            ['code' => '10001'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getPostalCodeTargeting($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class);
});

it('can update postal code targeting', function () {
    $config = new CampaignTargetingConfiguration($this->accountId, $this->campaignId);
    $postalCodes = ['postal_codes' => ['90001', '10001']];

    $responseData = json_encode(['success' => true]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('put')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->updatePostalCodeTargeting($config, $postalCodes);

    expect($result)->toBeInstanceOf(stdClass::class);
});

it('can get marketplace audience targeting', function () {
    $config = new CampaignTargetingConfiguration($this->accountId, $this->campaignId);

    $responseData = json_encode([
        'results' => [
            ['id' => 'aud-1', 'name' => 'Audience 1'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getMarketplaceAudienceTargeting($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class);
});

it('can update marketplace audience targeting', function () {
    $config = new CampaignTargetingConfiguration($this->accountId, $this->campaignId);
    $audiences = ['audiences' => ['aud-1', 'aud-2']];

    $responseData = json_encode(['success' => true]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('put')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->updateMarketplaceAudienceTargeting($config, $audiences);

    expect($result)->toBeInstanceOf(stdClass::class);
});

it('can get contextual targeting', function () {
    $config = new CampaignTargetingConfiguration($this->accountId, $this->campaignId);

    $responseData = json_encode([
        'results' => [
            ['id' => 'ctx-1', 'category' => 'Sports'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getContextualTargeting($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class);
});

it('can update contextual targeting', function () {
    $config = new CampaignTargetingConfiguration($this->accountId, $this->campaignId);
    $contextual = ['segments' => ['ctx-1', 'ctx-2']];

    $responseData = json_encode(['success' => true]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('put')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->updateContextualTargeting($config, $contextual);

    expect($result)->toBeInstanceOf(stdClass::class);
});
