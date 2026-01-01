<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\CampaignItems;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class AllCampaignItemsConfiguration implements PathConfigurationInterface
{
    public function __construct(
        private string $accountId,
        private string $campaignId
    ) {
    }

    public function getPath(): string
    {
        return strtr(
            URI::CAMPAIGN_ITEM_ALL_URI,
            [
                '{account_id}' => $this->accountId,
                '{campaign_id}' => $this->campaignId,
            ]
        );
    }
}
