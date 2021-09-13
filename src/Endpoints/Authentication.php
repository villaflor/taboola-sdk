<?php

namespace Villaflor\TaboolaSDK\Endpoints;

use stdClass;
use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\Connection\APIInterface;
use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\Connection\Traits\BodyAccessorTrait;
use Villaflor\TaboolaSDK\Definitions\URI;

class Authentication implements APIInterface
{
    use BodyAccessorTrait;

    private AdapterInterface $adapter;

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAccessToken(ConfigurationsInterface $authenticationConfig): stdClass
    {
        $accessToken = $this->adapter->post(URI::AUTH_URI, $authenticationConfig->getArray(), ['Content-Type' => 'application/x-www-form-urlencoded']);

        $this->body = json_decode($accessToken->getBody());

        return (object)['body' => $this->body];
    }
}
