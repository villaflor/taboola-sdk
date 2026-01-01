<?php

declare(strict_types=1);

/**
 * Example 3: Bulk Operations
 *
 * This example demonstrates how to perform bulk operations:
 * - Bulk update campaigns
 * - Bulk create campaign items
 * - Bulk update campaign items
 * - Bulk delete campaign items
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Villaflor\Connection\Auth\APIToken;
use Villaflor\TaboolaSDK\Configurations\CampaignItems\AllCampaignItemsConfiguration;
use Villaflor\TaboolaSDK\Configurations\Campaigns\AllCampaignsConfiguration;
use Villaflor\TaboolaSDK\Endpoints\CampaignItems;
use Villaflor\TaboolaSDK\Endpoints\Campaigns;
use Villaflor\TaboolaSDK\TaboolaClient;

// Configuration
$accountId = 'your-account-id';
$campaignId = 'your-campaign-id';
$accessToken = trim(file_get_contents(__DIR__ . '/token.txt'));

try {
    // Create authenticated client
    $client = new TaboolaClient(new APIToken($accessToken));
    $campaigns = new Campaigns($client);
    $items = new CampaignItems($client);

    echo "⚡ Bulk Operations Examples\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    // ═══════════════════════════════════════════════
    // 1. BULK UPDATE CAMPAIGNS
    // ═══════════════════════════════════════════════
    echo "1️⃣  Bulk updating campaigns...\n";

    $bulkCampaignConfig = new AllCampaignsConfiguration($accountId);

    // Prepare campaign updates
    $campaignUpdates = [
        [
            'id' => $campaignId,
            'cpc' => 0.60,
            'spending_limit' => 150.00,
        ],
        // Add more campaigns as needed
    ];

    $updatedCampaigns = $campaigns->bulkUpdateCampaigns(
        $bulkCampaignConfig,
        $campaignUpdates
    );

    echo "   ✅ Updated {$updatedCampaigns->metadata->total_results} campaigns\n";
    foreach ($updatedCampaigns->results as $campaign) {
        echo "   • {$campaign['name']} - CPC: \${$campaign['cpc']}\n";
    }
    echo "\n";

    // ═══════════════════════════════════════════════
    // 2. BULK CREATE CAMPAIGN ITEMS
    // ═══════════════════════════════════════════════
    echo "2️⃣  Bulk creating campaign items...\n";

    $bulkItemsConfig = new AllCampaignItemsConfiguration($accountId, $campaignId);

    // Prepare multiple items
    $newItems = [
        [
            'title' => '10 Amazing Tips You Need to Know',
            'description' => 'Discover the secrets that experts don\'t want you to know',
            'url' => 'https://example.com/article-1',
            'thumbnail_url' => 'https://example.com/images/thumb-1.jpg',
        ],
        [
            'title' => 'How to Save Money in 2024',
            'description' => 'Simple strategies that actually work',
            'url' => 'https://example.com/article-2',
            'thumbnail_url' => 'https://example.com/images/thumb-2.jpg',
        ],
        [
            'title' => 'The Ultimate Guide to Productivity',
            'description' => 'Get more done in less time with these proven methods',
            'url' => 'https://example.com/article-3',
            'thumbnail_url' => 'https://example.com/images/thumb-3.jpg',
        ],
        [
            'title' => 'Health Secrets Revealed',
            'description' => 'Transform your wellbeing with science-backed tips',
            'url' => 'https://example.com/article-4',
            'thumbnail_url' => 'https://example.com/images/thumb-4.jpg',
        ],
        [
            'title' => 'Tech Trends Shaping the Future',
            'description' => 'What you need to know about tomorrow\'s technology',
            'url' => 'https://example.com/article-5',
            'thumbnail_url' => 'https://example.com/images/thumb-5.jpg',
        ],
    ];

    $createdItems = $items->bulkCreateItems($bulkItemsConfig, $newItems);

    echo "   ✅ Created {$createdItems->metadata->total_results} items\n";
    $itemIds = [];
    foreach ($createdItems->results as $item) {
        echo "   • {$item['title']} (ID: {$item['id']})\n";
        $itemIds[] = $item['id'];
    }
    echo "\n";

    // ═══════════════════════════════════════════════
    // 3. BULK UPDATE CAMPAIGN ITEMS
    // ═══════════════════════════════════════════════
    echo "3️⃣  Bulk updating campaign items...\n";

    // Prepare item updates (e.g., pause all items)
    $itemUpdates = array_map(function ($itemId) {
        return [
            'id' => $itemId,
            'is_active' => false, // Pause the item
            'cpc' => 0.45, // Update CPC
        ];
    }, $itemIds);

    $updatedItems = $items->bulkUpdateItems($bulkItemsConfig, $itemUpdates);

    echo "   ✅ Updated {$updatedItems->metadata->total_results} items\n";
    foreach ($updatedItems->results as $item) {
        $status = $item['is_active'] ? 'Active' : 'Paused';
        echo "   • {$item['title']} - Status: {$status}, CPC: \${$item['cpc']}\n";
    }
    echo "\n";

    // ═══════════════════════════════════════════════
    // 4. BULK DELETE CAMPAIGN ITEMS
    // ═══════════════════════════════════════════════
    echo "4️⃣  Bulk deleting campaign items...\n";

    $deleteResult = $items->bulkDeleteItems($bulkItemsConfig, $itemIds);

    echo "   ✅ Deleted " . count($itemIds) . " items\n";
    echo "\n";

    // ═══════════════════════════════════════════════
    // PERFORMANCE TIPS
    // ═══════════════════════════════════════════════
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "⚡ Performance Benefits of Bulk Operations:\n\n";

    $itemCount = count($newItems);
    echo "   Single API Calls:\n";
    echo "   • Creating {$itemCount} items individually: {$itemCount} API calls\n";
    echo "   • Time: ~" . ($itemCount * 0.5) . " seconds\n\n";

    echo "   Bulk API Calls:\n";
    echo "   • Creating {$itemCount} items in bulk: 1 API call\n";
    echo "   • Time: ~0.5 seconds\n\n";

    echo "   💡 Savings: " . round(($itemCount - 1) / $itemCount * 100) . "% fewer API calls\n";
    echo "   💡 Speed: " . $itemCount . "x faster\n";

    echo "\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "✅ All bulk operations completed successfully!\n";
} catch (\Villaflor\TaboolaSDK\Exceptions\TaboolaException $e) {
    echo "❌ Taboola API Error: {$e->getMessage()}\n";
    exit(1);
} catch (\Exception $e) {
    echo "❌ Unexpected error: {$e->getMessage()}\n";
    exit(1);
}

echo "\n";
echo "📚 Best Practices:\n";
echo "   • Use bulk operations for 5+ items\n";
echo "   • Batch updates in groups of 50-100\n";
echo "   • Handle partial failures gracefully\n";
echo "   • Monitor API rate limits\n";
echo "   • Validate data before bulk operations\n";
