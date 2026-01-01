<?php

declare(strict_types=1);

/**
 * Example 2: Campaign Management
 *
 * This example demonstrates CRUD operations for campaigns:
 * - List all campaigns
 * - Get a single campaign
 * - Create a new campaign
 * - Update a campaign
 * - Duplicate a campaign
 * - Delete a campaign
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Villaflor\Connection\Auth\APIToken;
use Villaflor\TaboolaSDK\Configurations\Campaigns\AllCampaignsConfiguration;
use Villaflor\TaboolaSDK\Configurations\Campaigns\SingleCampaignConfiguration;
use Villaflor\TaboolaSDK\Definitions\AllCampaignsFilterDefinition;
use Villaflor\TaboolaSDK\Endpoints\Campaigns;
use Villaflor\TaboolaSDK\TaboolaClient;

// Configuration
$accountId = 'your-account-id';
$accessToken = trim(file_get_contents(__DIR__ . '/token.txt'));

try {
    // Create authenticated client
    $client = new TaboolaClient(new APIToken($accessToken));
    $campaigns = new Campaigns($client);

    echo "🎯 Campaign Management Examples\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    // ═══════════════════════════════════════════════
    // 1. LIST ALL CAMPAIGNS
    // ═══════════════════════════════════════════════
    echo "1️⃣  Fetching all campaigns...\n";

    $allCampaignsConfig = new AllCampaignsConfiguration(
        accountId: $accountId,
        filters: [
            AllCampaignsFilterDefinition::FETCH_LEVEL =>
                AllCampaignsFilterDefinition::FETCH_LEVEL_RECENT_AND_PAUSED_OPTIONS,
        ]
    );

    $allCampaigns = $campaigns->getAllCampaigns($allCampaignsConfig);

    echo "   Found {$allCampaigns->metadata->total_results} campaigns\n";
    foreach (array_slice($allCampaigns->results, 0, 3) as $campaign) {
        echo "   • {$campaign['name']} (ID: {$campaign['id']})\n";
    }
    echo "\n";

    // ═══════════════════════════════════════════════
    // 2. GET SINGLE CAMPAIGN
    // ═══════════════════════════════════════════════
    if (! empty($allCampaigns->results)) {
        $campaignId = $allCampaigns->results[0]['id'];

        echo "2️⃣  Fetching single campaign (ID: {$campaignId})...\n";

        $singleConfig = new SingleCampaignConfiguration($accountId, $campaignId);
        $campaign = $campaigns->getCampaign($singleConfig);

        echo "   Name: {$campaign->name}\n";
        echo "   Status: {$campaign->status}\n";
        echo "   Budget: \${$campaign->spending_limit}\n";
        echo "   CPC: \${$campaign->cpc}\n";
        echo "\n";
    }

    // ═══════════════════════════════════════════════
    // 3. CREATE NEW CAMPAIGN
    // ═══════════════════════════════════════════════
    echo "3️⃣  Creating new campaign...\n";

    $createConfig = new SingleCampaignConfiguration($accountId, '');
    $newCampaignData = [
        'name' => 'SDK Test Campaign ' . date('Y-m-d H:i:s'),
        'branding_text' => 'Example Brand',
        'cpc' => 0.50,
        'spending_limit' => 100.00,
        'spending_limit_model' => 'ENTIRE',
        'country_targeting' => [
            'type' => 'INCLUDE',
            'value' => ['US'],
        ],
        'publisher_targeting' => [
            'type' => 'ALL',
        ],
        'tracking_code' => 'utm_source=taboola&utm_campaign=test',
    ];

    $newCampaign = $campaigns->createCampaign($createConfig, $newCampaignData);

    echo "   ✅ Created campaign: {$newCampaign->name}\n";
    echo "   Campaign ID: {$newCampaign->id}\n";
    echo "\n";

    $createdCampaignId = $newCampaign->id;

    // ═══════════════════════════════════════════════
    // 4. UPDATE CAMPAIGN
    // ═══════════════════════════════════════════════
    echo "4️⃣  Updating campaign...\n";

    $updateConfig = new SingleCampaignConfiguration($accountId, $createdCampaignId);
    $updateData = [
        'name' => 'SDK Test Campaign (Updated)',
        'cpc' => 0.75,
    ];

    $updatedCampaign = $campaigns->updateCampaign($updateConfig, $updateData);

    echo "   ✅ Updated campaign\n";
    echo "   New name: {$updatedCampaign->name}\n";
    echo "   New CPC: \${$updatedCampaign->cpc}\n";
    echo "\n";

    // ═══════════════════════════════════════════════
    // 5. DUPLICATE CAMPAIGN
    // ═══════════════════════════════════════════════
    echo "5️⃣  Duplicating campaign...\n";

    $duplicateConfig = new SingleCampaignConfiguration($accountId, $createdCampaignId);
    $duplicateData = [
        'name' => 'SDK Test Campaign (Copy)',
    ];

    $duplicatedCampaign = $campaigns->duplicateCampaign($duplicateConfig, $duplicateData);

    echo "   ✅ Duplicated campaign\n";
    echo "   Original ID: {$createdCampaignId}\n";
    echo "   Duplicate ID: {$duplicatedCampaign->id}\n";
    echo "\n";

    // ═══════════════════════════════════════════════
    // 6. DELETE CAMPAIGN
    // ═══════════════════════════════════════════════
    echo "6️⃣  Deleting test campaigns...\n";

    // Delete original
    $deleteConfig = new SingleCampaignConfiguration($accountId, $createdCampaignId);
    $campaigns->deleteCampaign($deleteConfig);
    echo "   ✅ Deleted campaign {$createdCampaignId}\n";

    // Delete duplicate
    $deleteConfig2 = new SingleCampaignConfiguration($accountId, $duplicatedCampaign->id);
    $campaigns->deleteCampaign($deleteConfig2);
    echo "   ✅ Deleted campaign {$duplicatedCampaign->id}\n";

    echo "\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "✅ All campaign operations completed successfully!\n";
} catch (\Villaflor\TaboolaSDK\Exceptions\TaboolaException $e) {
    echo "❌ Taboola API Error: {$e->getMessage()}\n";
    exit(1);
} catch (\Exception $e) {
    echo "❌ Unexpected error: {$e->getMessage()}\n";
    exit(1);
}

echo "\n";
echo "📚 What you learned:\n";
echo "   • How to list campaigns with filters\n";
echo "   • How to get campaign details\n";
echo "   • How to create campaigns with configuration\n";
echo "   • How to update campaign settings\n";
echo "   • How to duplicate campaigns\n";
echo "   • How to delete campaigns\n";
