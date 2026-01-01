<?php

declare(strict_types=1);

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\TaboolaSDK\Configurations\Account\AccountDetailsConfiguration;
use Villaflor\TaboolaSDK\Configurations\Account\AdvertiserAccountsInNetworkConfiguration;
use Villaflor\TaboolaSDK\Configurations\Account\AllowedAccountsConfiguration;
use Villaflor\TaboolaSDK\Definitions\URI;
use Villaflor\TaboolaSDK\DTO\AccountResponse;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Endpoints\Account;

beforeEach(function () {
    $this->adapter = Mockery::mock(AdapterInterface::class);
    $this->endpoint = new Account($this->adapter);
});

afterEach(function () {
    Mockery::close();
});

it('can get account details', function () {
    $config = new AccountDetailsConfiguration();

    $response = mockResponseFromFixture('Account/account_details.json');

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->with(URI::API_URI . URI::ACCOUNT_DETAILS_URI)
        ->andReturn($response);

    $result = $this->endpoint->getAccountDetails($config);

    expect($result)->toBeInstanceOf(AccountResponse::class)
        ->and($result->body)->toBeInstanceOf(stdClass::class)
        ->and($result->body->id)->toBe('demo-advertiser')
        ->and($result->body->name)->toBe('Demo Advertiser Account')
        ->and($result->body->currency)->toBe('USD');
});

it('can get advertiser accounts in network', function () {
    $accountId = 'demo-account-001';
    $config = new AdvertiserAccountsInNetworkConfiguration($accountId);

    $response = mockResponseFromFixture('Account/advertiser_accounts.json');

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getAdvertiserAccountsInNetwork($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray()
        ->and($result->results)->toHaveCount(2);

    expect($result->results[0])->toBeInstanceOf(stdClass::class)
        ->and($result->results[0]->id)->toBe('advertiser-001')
        ->and($result->results[0]->currency)->toBe('USD');
});

it('can get allowed accounts', function () {
    $config = new AllowedAccountsConfiguration();

    $response = mockResponseFromFixture('Account/allowed_accounts.json');

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getAllowedAccounts($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray()
        ->and($result->results)->toHaveCount(3);

    expect($result->results[0])->toBeInstanceOf(stdClass::class)
        ->and($result->results[0]->id)->toBe('account-001')
        ->and($result->results[0]->type)->toBe('ADVERTISER');
});
