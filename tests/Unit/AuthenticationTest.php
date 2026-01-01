<?php

declare(strict_types=1);

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\TaboolaSDK\Configurations\AuthenticationConfiguration;
use Villaflor\TaboolaSDK\DTO\AuthenticationResponse;
use Villaflor\TaboolaSDK\Endpoints\Authentication;

beforeEach(function () {
    $this->adapter = Mockery::mock(AdapterInterface::class);
    $this->endpoint = new Authentication($this->adapter);
});

afterEach(function () {
    Mockery::close();
});

it('can get access token', function () {
    $config = new AuthenticationConfiguration('client-id', 'client-secret');

    $response = mockResponseFromFixture('Authentication/access_token.json');

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getAccessToken($config);

    expect($result)->toBeInstanceOf(AuthenticationResponse::class)
        ->and($result->accessToken)->toBe('a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6')
        ->and($result->tokenType)->toBe('Bearer')
        ->and($result->expiresIn)->toBe(43200);
});

it('throws exception on invalid json response', function () {
    $config = new AuthenticationConfiguration('client-id', 'client-secret');

    $response = mockResponse('invalid-json{');

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $this->endpoint->getAccessToken($config);
})->throws(\Villaflor\TaboolaSDK\Exceptions\JsonDecodeException::class);
