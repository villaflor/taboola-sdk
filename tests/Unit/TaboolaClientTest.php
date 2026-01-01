<?php

declare(strict_types=1);

use Villaflor\Connection\Auth\AuthInterface;
use Villaflor\TaboolaSDK\TaboolaClient;

it('can be instantiated with auth', function () {
    $auth = Mockery::mock(AuthInterface::class);
    $auth->shouldReceive('getHeaders')->andReturn(['Authorization' => 'Bearer test-token']);

    $client = new TaboolaClient($auth);

    expect($client)->toBeInstanceOf(TaboolaClient::class);
});

it('can be instantiated with custom base URI', function () {
    $auth = Mockery::mock(AuthInterface::class);
    $auth->shouldReceive('getHeaders')->andReturn(['Authorization' => 'Bearer test-token']);

    $customUri = 'https://custom.taboola.com/';
    $client = new TaboolaClient($auth, $customUri);

    expect($client)->toBeInstanceOf(TaboolaClient::class);
});

it('uses default base URI when none provided', function () {
    $auth = Mockery::mock(AuthInterface::class);
    $auth->shouldReceive('getHeaders')->andReturn(['Authorization' => 'Bearer test-token']);

    $client = new TaboolaClient($auth);

    expect($client)->toBeInstanceOf(TaboolaClient::class);
});

afterEach(function () {
    Mockery::close();
});
