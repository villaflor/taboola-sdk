<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\ConversionTracking;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class AllConversionRulesConfiguration implements PathConfigurationInterface
{
    public function __construct(
        private string $accountId
    ) {
    }

    public function getPath(): string
    {
        return strtr(
            URI::CONVERSION_RULES_ALL_URI,
            ['{account_id}' => $this->accountId]
        );
    }
}
