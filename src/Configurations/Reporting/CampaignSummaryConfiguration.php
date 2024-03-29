<?php

namespace Villaflor\TaboolaSDK\Configurations\Reporting;

use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

class CampaignSummaryConfiguration implements PathConfigurationInterface, ConfigurationsInterface
{
    private $config;
    private $pathConfig;

    public function __construct(string $accountID, string $dimension, array $config)
    {
        $this->config = $config;

        $this->pathConfig = [
            '{account_id}' => $accountID,
            '{dimension}' => $dimension,
        ];
    }

    public function getArray(): array
    {
        return $this->config;
    }

    public function getPath(): string
    {
        return strtr(URI::REPORT_CAMPAIGN_SUMMARY_URI, $this->pathConfig);
    }
}
