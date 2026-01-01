<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Endpoints;

use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\TaboolaSDK\Definitions\URI;
use Villaflor\TaboolaSDK\DTO\AuthenticationResponse;
use Villaflor\TaboolaSDK\Exceptions\JsonDecodeException;

final class Authentication extends AbstractEndpoint
{
    /**
     * @throws JsonDecodeException
     */
    public function getAccessToken(ConfigurationsInterface $authenticationConfig): AuthenticationResponse
    {
        $response = $this->adapter->post(
            URI::AUTH_URI,
            ['form_params' => $authenticationConfig->getArray()],
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );

        $data = $this->decodeJsonResponse($response->getBody());

        return AuthenticationResponse::fromStdClass($data);
    }
}
