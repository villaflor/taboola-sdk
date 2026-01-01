<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations;

use Villaflor\Connection\ConfigurationsInterface;

final readonly class AuthenticationConfiguration implements ConfigurationsInterface
{
    public function __construct(
        private string $clientId,
        private string $clientSecret,
        private string $grantType = 'client_credentials'
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function getArray(): array
    {
        return [
            'grant_type' => $this->grantType,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];
    }
}
