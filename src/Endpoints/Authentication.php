<?php

namespace Villaflor\TaboolaSDK\Endpoints;

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\Connection\APIInterface;
use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\Connection\Traits\BodyAccessorTrait;

class Authentication implements APIInterface
{
    use BodyAccessorTrait;

    private AdapterInterface $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAccessToken(ConfigurationsInterface $authenticationConfig): \stdClass
    {
        $accessToken = $this->adapter->post('oauth/token', $authenticationConfig->getArray(), ['Content-Type' => 'application/x-www-form-urlencoded']);
        $this->body = json_decode($accessToken->getBody());

        return (object)['body' => $this->body];
    }
}