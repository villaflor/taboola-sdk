<?php

declare(strict_types=1);

/**
 * Example 7: Audience Creation & Management
 *
 * This example demonstrates how to:
 * - Create custom audiences
 * - Manage audience lists
 * - Create lookalike audiences
 * - Use marketplace audiences
 * - Work with contextual segments
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Villaflor\Connection\Auth\APIToken;
use Villaflor\TaboolaSDK\Configurations\Audiences\AllAudiencesConfiguration;
use Villaflor\TaboolaSDK\Configurations\Audiences\ContextualSegmentsConfiguration;
use Villaflor\TaboolaSDK\Configurations\Audiences\LookalikeAudienceConfiguration;
use Villaflor\TaboolaSDK\Configurations\Audiences\MarketplaceAudienceConfiguration;
use Villaflor\TaboolaSDK\Configurations\Audiences\SingleAudienceConfiguration;
use Villaflor\TaboolaSDK\Endpoints\Audiences;
use Villaflor\TaboolaSDK\TaboolaClient;

// Configuration
$accountId = 'your-account-id';
$accessToken = trim(file_get_contents(__DIR__ . '/token.txt'));

try {
    // Create authenticated client
    $client = new TaboolaClient(new APIToken($accessToken));
    $audiences = new Audiences($client);

    echo "👥 Audience Creation & Management Examples\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    // ═══════════════════════════════════════════════
    // 1. LIST EXISTING AUDIENCES
    // ═══════════════════════════════════════════════
    echo "1️⃣  Listing existing audiences...\n\n";

    $allAudiencesConfig = new AllAudiencesConfiguration($accountId);
    $existingAudiences = $audiences->getAllAudiences($allAudiencesConfig);

    echo "   Found {$existingAudiences->metadata->total_results} audiences\n";

    if (! empty($existingAudiences->results)) {
        echo "\n   Your Audiences:\n";
        echo "   " . str_repeat('─', 70) . "\n";

        foreach (array_slice($existingAudiences->results, 0, 5) as $audience) {
            echo "   • {$audience['name']}\n";
            echo "     Type: {$audience['type']}\n";
            echo "     Size: " . number_format($audience['size'] ?? 0) . " users\n";
            echo "     Status: {$audience['status']}\n\n";
        }
    }

    // ═══════════════════════════════════════════════
    // 2. CREATE CUSTOM AUDIENCE
    // ═══════════════════════════════════════════════
    echo "2️⃣  Creating custom audience...\n\n";

    $createConfig = new SingleAudienceConfiguration($accountId, '');

    // Example: Create an audience from customer email list
    $newAudienceData = [
        'name' => 'High-Value Customers - ' . date('Y-m-d'),
        'description' => 'Customers who spent over $1000 in last 90 days',
        'type' => 'CUSTOM',
        'audience_source' => [
            'type' => 'CRM_DATA',
            'match_type' => 'EMAIL',
        ],
    ];

    $newAudience = $audiences->createAudience($createConfig, $newAudienceData);

    echo "   ✅ Created custom audience\n";
    echo "   Name: {$newAudience->name}\n";
    echo "   ID: {$newAudience->id}\n";
    echo "   Status: {$newAudience->status}\n\n";

    $customAudienceId = $newAudience->id;

    // ═══════════════════════════════════════════════
    // 3. UPLOAD AUDIENCE DATA
    // ═══════════════════════════════════════════════
    echo "3️⃣  Uploading audience data...\n\n";

    // In production, you would upload actual customer data
    // This is a simplified example
    $customerEmails = [
        'customer1@example.com',
        'customer2@example.com',
        'customer3@example.com',
        // ... more emails
    ];

    echo "   📤 Uploading " . count($customerEmails) . " customer emails...\n";
    echo "   (In production, use the bulk upload API endpoint)\n\n";

    // Simulated upload process
    echo "   Processing:\n";
    echo "   • Hashing emails for privacy\n";
    echo "   • Matching against Taboola network\n";
    echo "   • Building audience segment\n";
    echo "   ✅ Upload complete\n\n";

    // ═══════════════════════════════════════════════
    // 4. CREATE LOOKALIKE AUDIENCE
    // ═══════════════════════════════════════════════
    echo "4️⃣  Creating lookalike audience...\n\n";

    $lookalikeConfig = new LookalikeAudienceConfiguration($accountId);

    // Create lookalike based on custom audience
    $lookalikeData = [
        'name' => 'Lookalike - High Value Customers',
        'description' => 'Users similar to our best customers',
        'source_audience_id' => $customAudienceId,
        'similarity' => 1, // 1-10, where 1 is most similar
        'country' => 'US',
    ];

    $lookalikeAudience = $audiences->createLookalikeAudience(
        $lookalikeConfig,
        $lookalikeData
    );

    echo "   ✅ Created lookalike audience\n";
    echo "   Name: {$lookalikeAudience->name}\n";
    echo "   ID: {$lookalikeAudience->id}\n";
    echo "   Similarity Score: {$lookalikeData['similarity']}/10\n";
    echo "   Estimated Reach: " . number_format($lookalikeAudience->estimated_reach ?? 0) . " users\n\n";

    // ═══════════════════════════════════════════════
    // 5. BROWSE MARKETPLACE AUDIENCES
    // ═══════════════════════════════════════════════
    echo "5️⃣  Browsing marketplace audiences...\n\n";

    $marketplaceConfig = new MarketplaceAudienceConfiguration($accountId);
    $marketplaceAudiences = $audiences->getMarketplaceAudiences($marketplaceConfig);

    echo "   Available Marketplace Audiences:\n";
    echo "   " . str_repeat('─', 70) . "\n";

    // Group by category
    $categories = [];
    foreach ($marketplaceAudiences->results as $audience) {
        $category = $audience['category'] ?? 'Other';
        if (! isset($categories[$category])) {
            $categories[$category] = [];
        }
        $categories[$category][] = $audience;
    }

    foreach (array_slice($categories, 0, 5, true) as $category => $audienceList) {
        echo "\n   {$category}:\n";
        foreach (array_slice($audienceList, 0, 3) as $audience) {
            echo "   • {$audience['name']}\n";
            echo "     Provider: {$audience['provider']}\n";
            echo "     Reach: " . number_format($audience['reach'] ?? 0) . " users\n";
            echo "     CPM: \$" . ($audience['cpm'] ?? 'N/A') . "\n\n";
        }
    }

    // ═══════════════════════════════════════════════
    // 6. CONTEXTUAL SEGMENTS
    // ═══════════════════════════════════════════════
    echo "6️⃣  Working with contextual segments...\n\n";

    $contextualConfig = new ContextualSegmentsConfiguration($accountId);
    $contextualSegments = $audiences->getContextualSegments($contextualConfig);

    echo "   Available Contextual Segments:\n";
    echo "   " . str_repeat('─', 70) . "\n";

    // Show top segments by category
    $contextCategories = [];
    foreach ($contextualSegments->results as $segment) {
        $cat = $segment['category'] ?? 'General';
        if (! isset($contextCategories[$cat])) {
            $contextCategories[$cat] = [];
        }
        $contextCategories[$cat][] = $segment;
    }

    foreach (array_slice($contextCategories, 0, 4, true) as $cat => $segments) {
        echo "\n   {$cat}:\n";
        foreach (array_slice($segments, 0, 3) as $segment) {
            echo "   • {$segment['name']}\n";
        }
    }
    echo "\n";

    // ═══════════════════════════════════════════════
    // 7. UPDATE AUDIENCE
    // ═══════════════════════════════════════════════
    echo "7️⃣  Updating audience...\n\n";

    $updateConfig = new SingleAudienceConfiguration($accountId, $customAudienceId);

    $updateData = [
        'name' => 'Premium Customers - Updated',
        'description' => 'Our most valuable customer segment (updated)',
    ];

    $updatedAudience = $audiences->updateAudience($updateConfig, $updateData);

    echo "   ✅ Updated audience\n";
    echo "   New Name: {$updatedAudience->name}\n";
    echo "   New Description: {$updatedAudience->description}\n\n";

    // ═══════════════════════════════════════════════
    // 8. GET AUDIENCE DETAILS
    // ═══════════════════════════════════════════════
    echo "8️⃣  Fetching audience details...\n\n";

    $detailsConfig = new SingleAudienceConfiguration($accountId, $customAudienceId);
    $audienceDetails = $audiences->getAudience($detailsConfig);

    echo "   Audience Details:\n";
    echo "   " . str_repeat('─', 70) . "\n";
    echo "   Name: {$audienceDetails->name}\n";
    echo "   Type: {$audienceDetails->type}\n";
    echo "   Status: {$audienceDetails->status}\n";
    echo "   Size: " . number_format($audienceDetails->size ?? 0) . " users\n";
    echo "   Created: {$audienceDetails->created_at}\n";
    echo "   Last Updated: {$audienceDetails->updated_at}\n\n";

    // ═══════════════════════════════════════════════
    // 9. AUDIENCE STRATEGY GUIDE
    // ═══════════════════════════════════════════════
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📊 Audience Strategy Guide:\n\n";

    echo "   Audience Types & Use Cases:\n\n";

    echo "   1. Custom Audiences (Your Data):\n";
    echo "      • Website visitors (pixel tracking)\n";
    echo "      • Customer email lists\n";
    echo "      • App users\n";
    echo "      • CRM data\n";
    echo "      Best for: Retargeting, customer retention\n\n";

    echo "   2. Lookalike Audiences:\n";
    echo "      • Based on custom audiences\n";
    echo "      • Similarity scores 1-10\n";
    echo "      • Expand reach while maintaining quality\n";
    echo "      Best for: New customer acquisition\n\n";

    echo "   3. Marketplace Audiences (3rd Party):\n";
    echo "      • Pre-built segments\n";
    echo "      • Demographic targeting\n";
    echo "      • Interest-based segments\n";
    echo "      • Behavioral data\n";
    echo "      Best for: Broad reach, testing new markets\n\n";

    echo "   4. Contextual Segments:\n";
    echo "      • Content-based targeting\n";
    echo "      • No personal data\n";
    echo "      • Privacy-friendly\n";
    echo "      Best for: Brand safety, privacy compliance\n\n";

    // ═══════════════════════════════════════════════
    // 10. OPTIMIZATION TIPS
    // ═══════════════════════════════════════════════
    echo "   Optimization Tips:\n\n";

    echo "   Building Audiences:\n";
    echo "   ✓ Start with 1,000+ members minimum\n";
    echo "   ✓ Refresh data regularly (weekly/monthly)\n";
    echo "   ✓ Segment by behavior, not just demographics\n";
    echo "   ✓ Create exclusion audiences (converters)\n\n";

    echo "   Lookalike Strategy:\n";
    echo "   ✓ Use high-quality source audiences\n";
    echo "   ✓ Test similarity scores (1%, 5%, 10%)\n";
    echo "   ✓ Limit to specific countries initially\n";
    echo "   ✓ Combine with other targeting for precision\n\n";

    echo "   Testing Approach:\n";
    echo "   ✓ Test one audience type at a time\n";
    echo "   ✓ Run for minimum 7 days\n";
    echo "   ✓ Compare vs. broad targeting baseline\n";
    echo "   ✓ Monitor CPM, CTR, and CPA metrics\n\n";

    // ═══════════════════════════════════════════════
    // CLEANUP (Optional)
    // ═══════════════════════════════════════════════
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "🗑️  Cleanup test audiences...\n";

    $deleteConfig = new SingleAudienceConfiguration($accountId, $customAudienceId);
    $audiences->deleteAudience($deleteConfig);
    echo "   ✅ Deleted test audience: {$customAudienceId}\n";

    echo "\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "✅ All audience operations completed successfully!\n";
} catch (\Villaflor\TaboolaSDK\Exceptions\TaboolaException $e) {
    echo "❌ Taboola API Error: {$e->getMessage()}\n";
    exit(1);
} catch (\Exception $e) {
    echo "❌ Unexpected error: {$e->getMessage()}\n";
    exit(1);
}

echo "\n";
echo "📚 Key Takeaways:\n";
echo "   • Build diverse audience portfolio\n";
echo "   • Test custom vs. marketplace audiences\n";
echo "   • Use lookalikes to scale winners\n";
echo "   • Combine audience + contextual targeting\n";
echo "   • Monitor audience health (size, match rate)\n";
echo "   • Respect privacy regulations (GDPR, CCPA)\n";
echo "   • Refresh audiences regularly\n";
echo "   • Create exclusion lists for converters\n";
