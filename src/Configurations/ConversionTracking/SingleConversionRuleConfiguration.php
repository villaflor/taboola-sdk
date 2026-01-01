<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\ConversionTracking;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class SingleConversionRuleConfiguration implements PathConfigurationInterface
{
    public function __construct(
        private string $accountId,
        private string $conversionId
    ) {
    }

    public function getPath(): string
    {
        return strtr(
            URI::CONVERSION_RULE_SINGLE_URI,
            [
                '{account_id}' => $this->accountId,
                '{conversion_id}' => $this->conversionId,
            ]
        );
    }
}
