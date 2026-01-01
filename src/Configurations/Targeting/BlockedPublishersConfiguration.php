<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\Targeting;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class BlockedPublishersConfiguration implements PathConfigurationInterface
{
    public function __construct(
        private string $accountId
    ) {
    }

    public function getPath(): string
    {
        return strtr(
            URI::TARGETING_BLOCKED_PUBLISHERS_URI,
            ['{account_id}' => $this->accountId]
        );
    }
}
