<?php

declare(strict_types=1);

/**
 * Example 5: Targeting Setup
 *
 * This example demonstrates how to configure advanced targeting:
 * - Publisher targeting
 * - Geographic targeting (countries, regions, cities, postal codes)
 * - Marketplace audience targeting
 * - Contextual targeting
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Villaflor\Connection\Auth\APIToken;
use Villaflor\TaboolaSDK\Configurations\Campaigns\SingleCampaignConfiguration;
use Villaflor\TaboolaSDK\Configurations\Dictionary\CountryResourceConfiguration;
use Villaflor\TaboolaSDK\Configurations\Targeting\ContextualConfiguration;
use Villaflor\TaboolaSDK\Configurations\Targeting\MarketplaceAudienceConfiguration;
use Villaflor\TaboolaSDK\Configurations\Targeting\PostalCodesConfiguration;
use Villaflor\TaboolaSDK\Configurations\Targeting\PublishersConfiguration;
use Villaflor\TaboolaSDK\Definitions\CountryResourceTypeDefinition;
use Villaflor\TaboolaSDK\Definitions\PublishersFilterDefinition;
use Villaflor\TaboolaSDK\Endpoints\Campaigns;
use Villaflor\TaboolaSDK\Endpoints\Dictionary;
use Villaflor\TaboolaSDK\Endpoints\Targeting;
use Villaflor\TaboolaSDK\TaboolaClient;

// Configuration
$accountId = 'your-account-id';
$campaignId = 'your-campaign-id';
$accessToken = trim(file_get_contents(__DIR__ . '/token.txt'));

try {
    // Create authenticated client
    $client = new TaboolaClient(new APIToken($accessToken));
    $campaigns = new Campaigns($client);
    $targeting = new Targeting($client);
    $dictionary = new Dictionary($client);

    echo "🎯 Advanced Targeting Examples\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    // ═══════════════════════════════════════════════
    // 1. PUBLISHER TARGETING
    // ═══════════════════════════════════════════════
    echo "1️⃣  Publisher Targeting\n";
    echo "   (Select specific publishers for your campaign)\n\n";

    $publishersConfig = new PublishersConfiguration(
        accountId: $accountId,
        filters: [
            PublishersFilterDefinition::COUNTRY => 'US',
        ]
    );

    $publishers = $targeting->getPublishers($publishersConfig);

    echo "   Available Publishers (Top 10):\n";
    echo "   " . str_repeat('─', 70) . "\n";

    foreach (array_slice($publishers->results, 0, 10) as $publisher) {
        echo "   • {$publisher['name']} (Tier: {$publisher['tier']})\n";
    }
    echo "\n";

    // Update campaign with publisher targeting
    $campaignConfig = new SingleCampaignConfiguration($accountId, $campaignId);

    // Include specific publishers (premium sites)
    $publisherUpdate = [
        'publisher_targeting' => [
            'type' => 'INCLUDE',
            'value' => [
                'cnn.com',
                'reuters.com',
                'bloomberg.com',
            ],
        ],
    ];

    $campaigns->updateCampaign($campaignConfig, $publisherUpdate);
    echo "   ✅ Updated campaign with premium publisher targeting\n";
    echo "   Targeting: CNN, Reuters, Bloomberg\n\n";

    // ═══════════════════════════════════════════════
    // 2. GEOGRAPHIC TARGETING
    // ═══════════════════════════════════════════════
    echo "2️⃣  Geographic Targeting\n";
    echo "   (Target specific locations)\n\n";

    // A. Country Targeting
    echo "   A. Country Targeting:\n";
    $countryTargeting = [
        'country_targeting' => [
            'type' => 'INCLUDE',
            'value' => ['US', 'CA', 'GB', 'AU'],
        ],
    ];

    $campaigns->updateCampaign($campaignConfig, $countryTargeting);
    echo "   ✅ Targeting: USA, Canada, UK, Australia\n\n";

    // B. Regional Targeting (US States)
    echo "   B. Regional Targeting (US States):\n";

    $regionsConfig = new CountryResourceConfiguration(
        countryCode: 'US',
        resourceType: CountryResourceTypeDefinition::REGIONS
    );

    $regions = $dictionary->getCountryResource($regionsConfig);

    echo "   Available US States (sample):\n";
    foreach (array_slice($regions->results, 0, 5) as $region) {
        echo "   • {$region['name']} ({$region['code']})\n";
    }

    $regionTargeting = [
        'sub_country_targeting' => [
            'type' => 'INCLUDE',
            'value' => ['US-CA', 'US-NY', 'US-TX', 'US-FL'],
        ],
    ];

    $campaigns->updateCampaign($campaignConfig, $regionTargeting);
    echo "   ✅ Targeting: California, New York, Texas, Florida\n\n";

    // C. City Targeting
    echo "   C. City Targeting:\n";

    $citiesConfig = new CountryResourceConfiguration(
        countryCode: 'US',
        resourceType: CountryResourceTypeDefinition::CITIES
    );

    $cities = $dictionary->getCountryResource($citiesConfig);

    echo "   Available US Cities (sample):\n";
    foreach (array_slice($cities->results, 0, 5) as $city) {
        echo "   • {$city['name']}\n";
    }
    echo "\n";

    // D. Postal Code Targeting
    echo "   D. Postal Code Targeting:\n";

    $postalConfig = new PostalCodesConfiguration(
        accountId: $accountId,
        campaignId: $campaignId
    );

    // Get current postal code targeting
    $currentPostalCodes = $targeting->getPostalCodes($postalConfig);
    echo "   Current postal codes: " . count($currentPostalCodes->results) . "\n";

    // Set postal code targeting (high-income zip codes in CA)
    $postalCodeData = [
        'postal_codes' => [
            '90210', // Beverly Hills
            '94301', // Palo Alto
            '92037', // La Jolla
            '92660', // Newport Beach
            '94022', // Los Altos
        ],
    ];

    $targeting->setPostalCodes($postalConfig, $postalCodeData);
    echo "   ✅ Targeting high-income California zip codes\n\n";

    // ═══════════════════════════════════════════════
    // 3. MARKETPLACE AUDIENCE TARGETING
    // ═══════════════════════════════════════════════
    echo "3️⃣  Marketplace Audience Targeting\n";
    echo "   (Use pre-built audience segments)\n\n";

    $audienceConfig = new MarketplaceAudienceConfiguration(accountId: $accountId);
    $marketplaceAudiences = $targeting->getMarketplaceAudiences($audienceConfig);

    echo "   Available Audience Segments (Top 10):\n";
    echo "   " . str_repeat('─', 70) . "\n";

    foreach (array_slice($marketplaceAudiences->results, 0, 10) as $audience) {
        echo "   • {$audience['name']}\n";
        echo "     Category: {$audience['category']}\n";
        echo "     Reach: " . number_format($audience['reach'] ?? 0) . "\n\n";
    }

    // Apply audience targeting to campaign
    if (! empty($marketplaceAudiences->results)) {
        $audienceIds = array_slice(
            array_column($marketplaceAudiences->results, 'id'),
            0,
            3
        );

        $audienceTargeting = [
            'audience_targeting' => [
                'type' => 'INCLUDE',
                'value' => $audienceIds,
            ],
        ];

        $campaigns->updateCampaign($campaignConfig, $audienceTargeting);
        echo "   ✅ Applied top 3 marketplace audiences to campaign\n\n";
    }

    // ═══════════════════════════════════════════════
    // 4. CONTEXTUAL TARGETING
    // ═══════════════════════════════════════════════
    echo "4️⃣  Contextual Targeting\n";
    echo "   (Target based on page content)\n\n";

    $contextualConfig = new ContextualConfiguration(accountId: $accountId);
    $contextualSegments = $targeting->getContextual($contextualConfig);

    echo "   Available Contextual Segments:\n";
    echo "   " . str_repeat('─', 70) . "\n";

    // Group by category
    $categories = [];
    foreach ($contextualSegments->results as $segment) {
        $category = $segment['category'] ?? 'Other';
        if (! isset($categories[$category])) {
            $categories[$category] = [];
        }
        $categories[$category][] = $segment['name'];
    }

    foreach (array_slice($categories, 0, 5, true) as $category => $segments) {
        echo "   {$category}:\n";
        foreach (array_slice($segments, 0, 3) as $segment) {
            echo "   • {$segment}\n";
        }
        echo "\n";
    }

    // Apply contextual targeting
    if (! empty($contextualSegments->results)) {
        $contextualIds = array_slice(
            array_column($contextualSegments->results, 'id'),
            0,
            5
        );

        $contextualTargeting = [
            'contextual_targeting' => [
                'type' => 'INCLUDE',
                'value' => $contextualIds,
            ],
        ];

        $campaigns->updateCampaign($campaignConfig, $contextualTargeting);
        echo "   ✅ Applied contextual targeting to campaign\n\n";
    }

    // ═══════════════════════════════════════════════
    // 5. PLATFORM & DEVICE TARGETING
    // ═══════════════════════════════════════════════
    echo "5️⃣  Platform & Device Targeting\n";
    echo "   (Control where ads appear)\n\n";

    $platformTargeting = [
        'platform_targeting' => [
            'type' => 'INCLUDE',
            'value' => ['DESK', 'PHON', 'TBLT'], // Desktop, Phone, Tablet
        ],
        'os_targeting' => [
            'type' => 'INCLUDE',
            'value' => ['ANDROID', 'IOS', 'WINDOWS', 'OSX'],
        ],
    ];

    $campaigns->updateCampaign($campaignConfig, $platformTargeting);
    echo "   ✅ Targeting all platforms and major operating systems\n\n";

    // ═══════════════════════════════════════════════
    // TARGETING SUMMARY
    // ═══════════════════════════════════════════════
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📋 Campaign Targeting Summary:\n\n";

    $finalCampaign = $campaigns->getCampaign($campaignConfig);

    echo "   Geographic:\n";
    echo "   • Countries: " . implode(', ', $finalCampaign->country_targeting['value'] ?? []) . "\n";
    echo "   • Regions: " . implode(', ', $finalCampaign->sub_country_targeting['value'] ?? []) . "\n";
    echo "   • Postal Codes: 5 high-income areas\n\n";

    echo "   Publisher:\n";
    echo "   • Type: {$finalCampaign->publisher_targeting['type']}\n";
    echo "   • Publishers: " . count($finalCampaign->publisher_targeting['value'] ?? []) . "\n\n";

    echo "   Audience:\n";
    if (isset($finalCampaign->audience_targeting)) {
        echo "   • Segments: " . count($finalCampaign->audience_targeting['value'] ?? []) . "\n";
    }
    if (isset($finalCampaign->contextual_targeting)) {
        echo "   • Contextual: " . count($finalCampaign->contextual_targeting['value'] ?? []) . "\n";
    }

    echo "\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "✅ All targeting configurations completed successfully!\n";
} catch (\Villaflor\TaboolaSDK\Exceptions\TaboolaException $e) {
    echo "❌ Taboola API Error: {$e->getMessage()}\n";
    exit(1);
} catch (\Exception $e) {
    echo "❌ Unexpected error: {$e->getMessage()}\n";
    exit(1);
}

echo "\n";
echo "📚 Targeting Best Practices:\n";
echo "   • Start broad, then narrow based on performance\n";
echo "   • Use A/B testing for different targeting combos\n";
echo "   • Monitor audience reach vs. performance\n";
echo "   • Exclude low-performing segments regularly\n";
echo "   • Combine geographic + audience targeting for precision\n";
