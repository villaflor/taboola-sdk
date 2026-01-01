<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\Audiences;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class CustomAudienceConfiguration implements PathConfigurationInterface
{
    public function __construct(
        private string $accountId
    ) {
    }

    public function getPath(): string
    {
        return strtr(
            URI::AUDIENCE_CUSTOM_ALL_URI,
            ['{account_id}' => $this->accountId]
        );
    }
}
