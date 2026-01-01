<?php

declare(strict_types=1);

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\TaboolaSDK\Configurations\Audiences\CustomAudienceConfiguration;
use Villaflor\TaboolaSDK\Configurations\Audiences\LookalikeAudienceConfiguration;
use Villaflor\TaboolaSDK\Configurations\Audiences\MarketplaceAudienceConfiguration;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Endpoints\Audiences;

beforeEach(function () {
    $this->adapter = Mockery::mock(AdapterInterface::class);
    $this->endpoint = new Audiences($this->adapter);
    $this->accountId = 'demo-account-001';
});

afterEach(function () {
    Mockery::close();
});

it('can get custom audiences', function () {
    $config = new CustomAudienceConfiguration($this->accountId);

    $responseData = json_encode([
        'results' => [
            ['id' => 'aud-1', 'name' => 'Custom Audience 1'],
            ['id' => 'aud-2', 'name' => 'Custom Audience 2'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getCustomAudiences($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray()
        ->and($result->results)->toHaveCount(2);
});

it('can create custom audience', function () {
    $config = new CustomAudienceConfiguration($this->accountId);
    $audienceData = [
        'name' => 'New Custom Audience',
        'description' => 'Test audience',
    ];

    $responseData = json_encode([
        'id' => 'aud-3',
        'name' => 'New Custom Audience',
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->createCustomAudience($config, $audienceData);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->id)->toBe('aud-3');
});

it('can get marketplace audiences', function () {
    $config = new MarketplaceAudienceConfiguration();

    $responseData = json_encode([
        'results' => [
            ['id' => 'mkt-1', 'name' => 'Marketplace Audience 1'],
            ['id' => 'mkt-2', 'name' => 'Marketplace Audience 2'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getMarketplaceAudiences($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray();
});

it('can get lookalike audiences', function () {
    $config = new LookalikeAudienceConfiguration($this->accountId);

    $responseData = json_encode([
        'results' => [
            ['id' => 'lka-1', 'name' => 'Lookalike Audience 1'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getLookalikeAudiences($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class);
});

it('can create lookalike audience', function () {
    $config = new LookalikeAudienceConfiguration($this->accountId);
    $audienceData = [
        'name' => 'New Lookalike Audience',
        'source_audience_id' => 'aud-1',
    ];

    $responseData = json_encode([
        'id' => 'lka-2',
        'name' => 'New Lookalike Audience',
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->createLookalikeAudience($config, $audienceData);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->id)->toBe('lka-2');
});

it('can get contextual segments', function () {
    $responseData = json_encode([
        'results' => [
            ['id' => 'seg-1', 'name' => 'Sports'],
            ['id' => 'seg-2', 'name' => 'Technology'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getContextualSegments();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray();
});
