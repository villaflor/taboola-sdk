<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\Targeting;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class CampaignTargetingConfiguration implements PathConfigurationInterface
{
    public function __construct(
        private string $accountId,
        private string $campaignId,
        private string $targetingType = 'postal_code'
    ) {
    }

    public function getPath(): string
    {
        return match ($this->targetingType) {
            'postal_code' => strtr(
                URI::TARGETING_POSTAL_CODES_URI,
                [
                    '{account_id}' => $this->accountId,
                    '{campaign_id}' => $this->campaignId,
                ]
            ),
            'marketplace_audience' => strtr(
                URI::TARGETING_MARKETPLACE_AUDIENCE_URI,
                [
                    '{account_id}' => $this->accountId,
                    '{campaign_id}' => $this->campaignId,
                ]
            ),
            'contextual' => strtr(
                URI::TARGETING_CONTEXTUAL_URI,
                [
                    '{account_id}' => $this->accountId,
                    '{campaign_id}' => $this->campaignId,
                ]
            ),
            default => strtr(
                URI::TARGETING_POSTAL_CODES_URI,
                [
                    '{account_id}' => $this->accountId,
                    '{campaign_id}' => $this->campaignId,
                ]
            ),
        };
    }
}
