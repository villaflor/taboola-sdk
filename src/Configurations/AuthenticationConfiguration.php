<?php

namespace Villaflor\TaboolaSDK\Configurations;

use Villaflor\Connection\ConfigurationsInterface;

class AuthenticationConfiguration implements ConfigurationsInterface
{
    private array $config;

    /**
     * @param string $clientID
     * @param string $clientSecret
     */
    public function __construct(string $clientID, string $clientSecret)
    {
        //For the Client Credentials flow, grant_type is always client_credentials.
        $this->config['grant_type'] = 'client_credentials';

        $this->config['client_id'] = $clientID;
        $this->config['client_secret'] = $clientSecret;
    }

    public function getArray(): array
    {
        return $this->config;
    }
}
