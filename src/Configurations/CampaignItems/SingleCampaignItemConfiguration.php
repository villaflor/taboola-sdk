<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\CampaignItems;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class SingleCampaignItemConfiguration implements PathConfigurationInterface
{
    public function __construct(
        private string $accountId,
        private string $campaignId,
        private string $itemId
    ) {
    }

    public function getPath(): string
    {
        // For create operations, itemId might be empty
        if (empty($this->itemId)) {
            return strtr(
                URI::CAMPAIGN_ITEM_CREATE_URI,
                [
                    '{account_id}' => $this->accountId,
                    '{campaign_id}' => $this->campaignId,
                ]
            );
        }

        return strtr(
            URI::CAMPAIGN_ITEM_SINGLE_URI,
            [
                '{account_id}' => $this->accountId,
                '{campaign_id}' => $this->campaignId,
                '{item_id}' => $this->itemId,
            ]
        );
    }
}
