<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\Campaigns;

use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class AllCampaignsConfiguration implements PathConfigurationInterface, ConfigurationsInterface
{
    /**
     * @param array<string, mixed> $filters
     */
    public function __construct(
        private string $accountId,
        private array $filters = []
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function getArray(): array
    {
        return $this->filters;
    }

    public function getPath(): string
    {
        return strtr(
            URI::CAMPAIGN_ALL_CAMPAIGNS_URI,
            ['{account_id}' => $this->accountId]
        );
    }
}
