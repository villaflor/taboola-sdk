<?php

namespace Villaflor\TaboolaSDK\Configurations\Campaigns;

use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

class AllCampaignsConfiguration implements PathConfigurationInterface, ConfigurationsInterface
{
    private $config;
    private $pathConfig;

    public function __construct(string $accountID, array $config)
    {
        $this->config = $config;

        $this->pathConfig = [
            '{account_id}' => $accountID,
        ];
    }

    public function getArray(): array
    {
        return $this->config;
    }

    public function getPath(): string
    {
        return strtr(URI::CAMPAIGN_ALL_CAMPAIGNS_URI, $this->pathConfig);
    }
}
