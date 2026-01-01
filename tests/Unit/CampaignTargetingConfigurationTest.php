<?php

declare(strict_types=1);

use Villaflor\TaboolaSDK\Configurations\Targeting\CampaignTargetingConfiguration;
use Villaflor\TaboolaSDK\Definitions\URI;

beforeEach(function () {
    $this->accountId = 'demo-account-001';
    $this->campaignId = 'campaign-123';
});

it('generates correct path for postal code targeting', function () {
    $config = new CampaignTargetingConfiguration($this->accountId, $this->campaignId, 'postal_code');

    $expectedPath = strtr(
        URI::TARGETING_POSTAL_CODES_URI,
        [
            '{account_id}' => $this->accountId,
            '{campaign_id}' => $this->campaignId,
        ]
    );

    expect($config->getPath())->toBe($expectedPath);
});

it('generates correct path for marketplace audience targeting', function () {
    $config = new CampaignTargetingConfiguration($this->accountId, $this->campaignId, 'marketplace_audience');

    $expectedPath = strtr(
        URI::TARGETING_MARKETPLACE_AUDIENCE_URI,
        [
            '{account_id}' => $this->accountId,
            '{campaign_id}' => $this->campaignId,
        ]
    );

    expect($config->getPath())->toBe($expectedPath);
});

it('generates correct path for contextual targeting', function () {
    $config = new CampaignTargetingConfiguration($this->accountId, $this->campaignId, 'contextual');

    $expectedPath = strtr(
        URI::TARGETING_CONTEXTUAL_URI,
        [
            '{account_id}' => $this->accountId,
            '{campaign_id}' => $this->campaignId,
        ]
    );

    expect($config->getPath())->toBe($expectedPath);
});

it('defaults to postal code for unknown targeting type', function () {
    $config = new CampaignTargetingConfiguration($this->accountId, $this->campaignId, 'unknown');

    $expectedPath = strtr(
        URI::TARGETING_POSTAL_CODES_URI,
        [
            '{account_id}' => $this->accountId,
            '{campaign_id}' => $this->campaignId,
        ]
    );

    expect($config->getPath())->toBe($expectedPath);
});

it('defaults to postal code when no targeting type specified', function () {
    $config = new CampaignTargetingConfiguration($this->accountId, $this->campaignId);

    $expectedPath = strtr(
        URI::TARGETING_POSTAL_CODES_URI,
        [
            '{account_id}' => $this->accountId,
            '{campaign_id}' => $this->campaignId,
        ]
    );

    expect($config->getPath())->toBe($expectedPath);
});
