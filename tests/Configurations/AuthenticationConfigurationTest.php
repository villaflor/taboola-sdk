<?php

namespace Villaflor\TaboolaSDK\Tests\Configurations;

use Villaflor\TaboolaSDK\Configurations\AuthenticationConfiguration;
use Villaflor\TaboolaSDK\Tests\TestCase;

class AuthenticationConfigurationTest extends TestCase
{
    public function testGetArray()
    {
        $authenticationConfig = new AuthenticationConfiguration('MY_ID', 'MY_SECRET');

        $config = $authenticationConfig->getArray();
        $this->assertEquals('MY_ID', $config['client_id']);
        $this->assertEquals('MY_SECRET', $config['client_secret']);
        $this->assertEquals('client_credentials', $config['grant_type']);
    }
}
