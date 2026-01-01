<?php

declare(strict_types=1);

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\TaboolaSDK\Configurations\ConversionTracking\AllConversionRulesConfiguration;
use Villaflor\TaboolaSDK\Configurations\ConversionTracking\SingleConversionRuleConfiguration;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Endpoints\ConversionTracking;

beforeEach(function () {
    $this->adapter = Mockery::mock(AdapterInterface::class);
    $this->endpoint = new ConversionTracking($this->adapter);
    $this->accountId = 'demo-account-001';
});

afterEach(function () {
    Mockery::close();
});

it('can get all conversion rules', function () {
    $config = new AllConversionRulesConfiguration($this->accountId);

    $responseData = json_encode([
        'results' => [
            ['id' => 'conv-1', 'name' => 'Purchase'],
            ['id' => 'conv-2', 'name' => 'Signup'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getAllConversionRules($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray()
        ->and($result->results)->toHaveCount(2);
});

it('can get single conversion rule', function () {
    $config = new SingleConversionRuleConfiguration($this->accountId, 'conv-1');

    $responseData = json_encode([
        'id' => 'conv-1',
        'name' => 'Purchase',
        'value' => 100,
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getConversionRule($config);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->id)->toBe('conv-1')
        ->and($result->name)->toBe('Purchase');
});

it('can create conversion rule', function () {
    $config = new AllConversionRulesConfiguration($this->accountId);
    $conversionData = [
        'name' => 'New Conversion',
        'value' => 50,
    ];

    $responseData = json_encode([
        'id' => 'conv-3',
        'name' => 'New Conversion',
        'value' => 50,
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->createConversionRule($config, $conversionData);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->id)->toBe('conv-3')
        ->and($result->name)->toBe('New Conversion');
});

it('can update conversion rule', function () {
    $config = new SingleConversionRuleConfiguration($this->accountId, 'conv-1');
    $conversionData = [
        'name' => 'Updated Purchase',
        'value' => 150,
    ];

    $responseData = json_encode([
        'id' => 'conv-1',
        'name' => 'Updated Purchase',
        'value' => 150,
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->updateConversionRule($config, $conversionData);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->name)->toBe('Updated Purchase')
        ->and($result->value)->toBe(150);
});
