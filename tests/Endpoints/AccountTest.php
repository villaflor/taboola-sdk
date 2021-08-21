<?php

namespace Villaflor\TaboolaSDK\Tests\Endpoints;

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\TaboolaSDK\Endpoints\Account;
use Villaflor\TaboolaSDK\Tests\TestCase;

class AccountTest extends TestCase
{
    public function testGetAccountDetails()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Account/getAccountDetails.json');

        $mock = $this->getMockBuilder(AdapterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())->method('get');

        $account = new Account($mock);
        $result = $account->getAccountDetails();

        $this->assertObjectHasAttribute('result', $result);

        $this->assertEquals('1234', $result->result->id);
        $this->assertEquals('1234', $account->getBody()->id);
    }
}
