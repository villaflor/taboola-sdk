<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\Campaigns;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class SingleCampaignConfiguration implements PathConfigurationInterface
{
    public function __construct(
        private string $accountId,
        private string $campaignId
    ) {
    }

    public function getPath(): string
    {
        // For create operations, campaignId might be empty, so use appropriate URI
        if (empty($this->campaignId)) {
            return strtr(
                URI::CAMPAIGN_CREATE_URI,
                ['{account_id}' => $this->accountId]
            );
        }

        return strtr(
            URI::CAMPAIGN_SINGLE_URI,
            [
                '{account_id}' => $this->accountId,
                '{campaign_id}' => $this->campaignId,
            ]
        );
    }
}
