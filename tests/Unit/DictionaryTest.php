<?php

declare(strict_types=1);

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\TaboolaSDK\Configurations\Dictionary\CountryResourceConfiguration;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Endpoints\Dictionary;

beforeEach(function () {
    $this->adapter = Mockery::mock(AdapterInterface::class);
    $this->endpoint = new Dictionary($this->adapter);
});

afterEach(function () {
    Mockery::close();
});

it('can get countries', function () {
    $responseData = json_encode([
        'results' => [
            ['code' => 'US', 'name' => 'United States'],
            ['code' => 'CA', 'name' => 'Canada'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getCountries();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray()
        ->and($result->results)->toHaveCount(2);
});

it('can get regions by country', function () {
    $config = new CountryResourceConfiguration('US');

    $responseData = json_encode([
        'results' => [
            ['code' => 'CA', 'name' => 'California'],
            ['code' => 'NY', 'name' => 'New York'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getRegions($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray();
});

it('can get cities by country', function () {
    $config = new CountryResourceConfiguration('US');

    $responseData = json_encode([
        'results' => [
            ['name' => 'New York'],
            ['name' => 'Los Angeles'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getCities($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class);
});

it('can get postal codes', function () {
    $config = new CountryResourceConfiguration('US');

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

    $result = $this->endpoint->getPostalCodes($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class);
});

it('can get platforms', function () {
    $responseData = json_encode([
        'results' => [
            ['name' => 'Desktop'],
            ['name' => 'Mobile'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getPlatforms();

    expect($result)->toBeInstanceOf(CollectionResponse::class);
});

it('can get operating systems', function () {
    $responseData = json_encode([
        'results' => [
            ['name' => 'iOS'],
            ['name' => 'Android'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getOperatingSystems();

    expect($result)->toBeInstanceOf(CollectionResponse::class);
});

it('can get browsers', function () {
    $responseData = json_encode([
        'results' => [
            ['name' => 'Chrome'],
            ['name' => 'Safari'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getBrowsers();

    expect($result)->toBeInstanceOf(CollectionResponse::class);
});
