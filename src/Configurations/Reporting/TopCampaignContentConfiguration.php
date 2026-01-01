<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\Reporting;

use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class TopCampaignContentConfiguration implements ConfigurationsInterface, PathConfigurationInterface
{
    /**
     * @param array<string, mixed> $filters
     */
    public function __construct(
        private string $accountId,
        private string $dimension,
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
            URI::REPORT_TOP_CAMPAIGN_CONTENT_URI,
            [
                '{account_id}' => $this->accountId,
                '{dimension}' => $this->dimension,
            ]
        );
    }
}
