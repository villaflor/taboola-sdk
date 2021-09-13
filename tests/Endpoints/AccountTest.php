<?php

namespace Villaflor\TaboolaSDK\Tests\Endpoints;

use Villaflor\Connection\Auth\APIToken;
use Villaflor\TaboolaSDK\Configurations\Account\AccountDetailsConfiguration;
use Villaflor\TaboolaSDK\Configurations\Account\AdvertiserAccountsInNetworkConfiguration;
use Villaflor\TaboolaSDK\Configurations\Account\AllowedAccountsConfiguration;
use Villaflor\TaboolaSDK\Definitions\URI;
use Villaflor\TaboolaSDK\Endpoints\Account;
use Villaflor\TaboolaSDK\TaboolaClient;
use Villaflor\TaboolaSDK\Tests\TestCase;

class AccountTest extends TestCase
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

    public function testGetAccountDetails()
    {
        $config = new AccountDetailsConfiguration();

        $this->assertEquals(URI::ACCOUNT_DETAILS_URI, $config->getPath());

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Account/getAccountDetails.json');

        $this->mock->method('get')->willReturn($response);
        $this->mock->expects($this->once())->method('get');

        $account = new Account($this->mock);

        $result = $account->getAccountDetails($config);

        $this->assertObjectHasAttribute('body', $result);

        $this->assertEquals('1234', $result->body->id);

        $this->assertEquals('1234', $account->getBody()->id);
    }

    public function testGetAdvertiserAccountsInNetwork()
    {
        $config = new AdvertiserAccountsInNetworkConfiguration($this->accountID);

        $this->assertEquals($this->accountID . "/advertisers", $config->getPath());

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Account/getAdvertiserAccountsInNetwork.json');

        $this->mock->method('get')->willReturn($response);
        $this->mock->expects($this->once())->method('get');

        $account = new Account($this->mock);

        $result = $account->getAdvertiserAccountsInNetwork($config);

        $this->assertObjectHasAttribute('results', $result);
        $this->assertObjectHasAttribute('metadata', $result);

        $this->assertEquals('1306', $result->results[0]->id);
        $this->assertEquals('1307', $result->results[1]->id);

        $this->assertEquals(2, $result->metadata->total);

        $this->assertEquals('1306', $account->getBody()->results[0]->id);
        $this->assertEquals('1307', $account->getBody()->results[1]->id);
    }

    public function testGetAllowedAccounts()
    {
        $config = new AllowedAccountsConfiguration();

        $this->assertEquals("users/current/allowed-accounts", $config->getPath());

        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Account/getAllowedAccounts.json');

        $this->mock->method('get')->willReturn($response);
        $this->mock->expects($this->once())->method('get');

        $account = new Account($this->mock);

        $result = $account->getAllowedAccounts($config);

        $this->assertObjectHasAttribute('results', $result);
        $this->assertObjectHasAttribute('metadata', $result);

        $this->assertEquals('1163', $result->results[0]->id);
        $this->assertEquals('1164', $result->results[1]->id);

        $this->assertEquals('1163', $account->getBody()->results[0]->id);
        $this->assertEquals('1164', $account->getBody()->results[1]->id);
    }
}
