<?php

namespace Villaflor\TaboolaSDK\Tests\Endpoints;

use Villaflor\Connection\Auth\None;
use Villaflor\TaboolaSDK\Configurations\AuthenticationConfiguration;
use Villaflor\TaboolaSDK\Endpoints\Authentication;
use Villaflor\TaboolaSDK\TaboolaClient;
use Villaflor\TaboolaSDK\Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function testGetAccessToken()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/Authentication/getAccessToken.json');

        $mock = $this->getMockBuilder(TaboolaClient::class)
            ->setConstructorArgs([
                new None()
            ])
            ->getMock();

        $mock->method('post')->willReturn($response);
        $mock->expects($this->once())->method('post');

        $authentication = new Authentication($mock);

        $authenticationConfig = new AuthenticationConfiguration('MY_ID', 'MY_SECRET');

        $result = $authentication->getAccessToken($authenticationConfig);

        $this->assertObjectHasAttribute('body', $result);

        $this->assertEquals('CZ0OAAAAAAAAEdt7AgAAAAAAGAEgAClebYBnbQEAADooMDMyMDg2MmExZWNlYjIyYWJhMjc1OGI4NzJlMGZhNWI5ZDYxN2Q0YkAC::644420::78997c', $result->body->access_token);

        $this->assertEquals('CZ0OAAAAAAAAEdt7AgAAAAAAGAEgAClebYBnbQEAADooMDMyMDg2MmExZWNlYjIyYWJhMjc1OGI4NzJlMGZhNWI5ZDYxN2Q0YkAC::644420::78997c', $authentication->getBody()->access_token);
    }
}
