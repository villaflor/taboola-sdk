<?php

declare(strict_types=1);

/**
 * Example 6: Image Upload & Management
 *
 * This example demonstrates how to:
 * - Upload images for campaign items
 * - Browse media library
 * - Manage uploaded images
 * - Use images in campaign items
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Villaflor\Connection\Auth\APIToken;
use Villaflor\TaboolaSDK\Configurations\CampaignItems\AllCampaignItemsConfiguration;
use Villaflor\TaboolaSDK\Configurations\CampaignItems\SingleCampaignItemConfiguration;
use Villaflor\TaboolaSDK\Configurations\Images\MediaLibraryConfiguration;
use Villaflor\TaboolaSDK\Configurations\Images\UploadImageConfiguration;
use Villaflor\TaboolaSDK\Endpoints\CampaignItems;
use Villaflor\TaboolaSDK\Endpoints\Images;
use Villaflor\TaboolaSDK\TaboolaClient;

// Configuration
$accountId = 'your-account-id';
$campaignId = 'your-campaign-id';
$accessToken = trim(file_get_contents(__DIR__ . '/token.txt'));

try {
    // Create authenticated client
    $client = new TaboolaClient(new APIToken($accessToken));
    $images = new Images($client);
    $items = new CampaignItems($client);

    echo "🖼️  Image Upload & Management Examples\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    // ═══════════════════════════════════════════════
    // 1. UPLOAD IMAGES
    // ═══════════════════════════════════════════════
    echo "1️⃣  Uploading images...\n\n";

    // For this example, we'll create some sample image URLs
    // In production, you would upload actual image files
    $imageUrls = [
        'https://example.com/images/product-1.jpg',
        'https://example.com/images/product-2.jpg',
        'https://example.com/images/promotion-banner.jpg',
    ];

    $uploadedImages = [];

    foreach ($imageUrls as $index => $imageUrl) {
        echo "   Uploading image " . ($index + 1) . "...\n";

        $uploadConfig = new UploadImageConfiguration(
            accountId: $accountId,
            url: $imageUrl
        );

        $uploadedImage = $images->uploadImage($uploadConfig);

        $uploadedImages[] = [
            'url' => $uploadedImage->url,
            'id' => $uploadedImage->id ?? null,
        ];

        echo "   ✅ Uploaded: {$uploadedImage->url}\n";

        // Optional: Add delay to respect rate limits
        usleep(500000); // 0.5 second delay
    }

    echo "\n   Total images uploaded: " . count($uploadedImages) . "\n\n";

    // ═══════════════════════════════════════════════
    // 2. BROWSE MEDIA LIBRARY
    // ═══════════════════════════════════════════════
    echo "2️⃣  Browsing media library...\n\n";

    $libraryConfig = new MediaLibraryConfiguration(accountId: $accountId);
    $mediaLibrary = $images->getMediaLibrary($libraryConfig);

    echo "   Media Library Contents:\n";
    echo "   " . str_repeat('─', 70) . "\n";
    echo "   Total images: {$mediaLibrary->metadata->total_results}\n\n";

    echo "   Recent uploads (last 10):\n";
    foreach (array_slice($mediaLibrary->results, 0, 10) as $media) {
        $uploadDate = isset($media['created_at'])
            ? date('Y-m-d H:i', strtotime($media['created_at']))
            : 'Unknown';

        echo "   • {$media['url']}\n";
        echo "     Size: {$media['width']}x{$media['height']}px\n";
        echo "     Uploaded: {$uploadDate}\n\n";
    }

    // ═══════════════════════════════════════════════
    // 3. IMAGE SPECIFICATIONS & BEST PRACTICES
    // ═══════════════════════════════════════════════
    echo "3️⃣  Image Specifications\n\n";

    echo "   Recommended Dimensions:\n";
    echo "   • Primary Image: 1200x628px (1.91:1 ratio)\n";
    echo "   • Square Image: 1200x1200px (1:1 ratio)\n";
    echo "   • Vertical Image: 1080x1920px (9:16 ratio)\n\n";

    echo "   Technical Requirements:\n";
    echo "   • Format: JPG, PNG, or GIF\n";
    echo "   • Max File Size: 5MB\n";
    echo "   • Min Width: 600px\n";
    echo "   • Min Height: 400px\n\n";

    echo "   Quality Guidelines:\n";
    echo "   • High resolution (avoid pixelation)\n";
    echo "   • Relevant to content\n";
    echo "   • Eye-catching and clear\n";
    echo "   • No excessive text (20% rule)\n";
    echo "   • Proper contrast and brightness\n\n";

    // ═══════════════════════════════════════════════
    // 4. CREATE CAMPAIGN ITEMS WITH IMAGES
    // ═══════════════════════════════════════════════
    echo "4️⃣  Creating campaign items with uploaded images...\n\n";

    $itemsConfig = new AllCampaignItemsConfiguration($accountId, $campaignId);

    // Create items using the uploaded images
    $newItems = [];
    foreach ($uploadedImages as $index => $image) {
        $newItems[] = [
            'title' => 'Product Showcase ' . ($index + 1),
            'description' => 'Discover amazing products and exclusive deals',
            'url' => 'https://example.com/product-' . ($index + 1),
            'thumbnail_url' => $image['url'],
        ];
    }

    $createdItems = $items->bulkCreateItems($itemsConfig, $newItems);

    echo "   ✅ Created {$createdItems->metadata->total_results} campaign items\n\n";

    foreach ($createdItems->results as $item) {
        echo "   • {$item['title']}\n";
        echo "     ID: {$item['id']}\n";
        echo "     Image: {$item['thumbnail_url']}\n\n";
    }

    // ═══════════════════════════════════════════════
    // 5. UPDATE ITEM IMAGE
    // ═══════════════════════════════════════════════
    echo "5️⃣  Updating item image...\n\n";

    if (! empty($createdItems->results) && ! empty($mediaLibrary->results)) {
        $itemToUpdate = $createdItems->results[0];
        $newImage = $mediaLibrary->results[0];

        $updateConfig = new SingleCampaignItemConfiguration(
            accountId: $accountId,
            campaignId: $campaignId,
            itemId: $itemToUpdate['id']
        );

        $updateData = [
            'thumbnail_url' => $newImage['url'],
        ];

        $updatedItem = $items->updateItem($updateConfig, $updateData);

        echo "   ✅ Updated item image\n";
        echo "   Item: {$updatedItem->title}\n";
        echo "   New Image: {$updatedItem->thumbnail_url}\n\n";
    }

    // ═══════════════════════════════════════════════
    // 6. IMAGE PERFORMANCE TRACKING
    // ═══════════════════════════════════════════════
    echo "6️⃣  Image Performance Tips\n\n";

    echo "   A/B Testing Images:\n";
    echo "   • Create duplicate items with different images\n";
    echo "   • Monitor CTR for each variant\n";
    echo "   • Pause low-performing images\n";
    echo "   • Scale winners\n\n";

    echo "   Performance Indicators:\n";
    echo "   • CTR (Click-Through Rate) - Primary metric\n";
    echo "   • Engagement rate - Time on page\n";
    echo "   • Conversion rate - Final action\n";
    echo "   • Cost per acquisition - ROI metric\n\n";

    echo "   Optimization Strategy:\n";
    echo "   1. Upload 3-5 image variants per item\n";
    echo "   2. Run for 7 days to gather data\n";
    echo "   3. Identify top 20% performers\n";
    echo "   4. Pause bottom 20%\n";
    echo "   5. Create new variants inspired by winners\n";
    echo "   6. Repeat the cycle\n\n";

    // ═══════════════════════════════════════════════
    // 7. BATCH IMAGE OPERATIONS
    // ═══════════════════════════════════════════════
    echo "7️⃣  Batch Image Operations\n\n";

    // Example: Update multiple items with different images
    if (! empty($createdItems->results)) {
        $itemUpdates = [];
        foreach ($createdItems->results as $index => $item) {
            if (isset($uploadedImages[$index])) {
                $itemUpdates[] = [
                    'id' => $item['id'],
                    'thumbnail_url' => $uploadedImages[$index]['url'],
                ];
            }
        }

        if (! empty($itemUpdates)) {
            $bulkUpdated = $items->bulkUpdateItems($itemsConfig, $itemUpdates);
            echo "   ✅ Bulk updated {$bulkUpdated->metadata->total_results} items with new images\n\n";
        }
    }

    // ═══════════════════════════════════════════════
    // CLEANUP (Optional)
    // ═══════════════════════════════════════════════
    echo "8️⃣  Cleanup test items...\n";

    if (! empty($createdItems->results)) {
        $itemIds = array_column($createdItems->results, 'id');
        $items->bulkDeleteItems($itemsConfig, $itemIds);
        echo "   ✅ Deleted " . count($itemIds) . " test items\n";
    }

    echo "\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "✅ All image operations completed successfully!\n";
} catch (\Villaflor\TaboolaSDK\Exceptions\TaboolaException $e) {
    echo "❌ Taboola API Error: {$e->getMessage()}\n";
    exit(1);
} catch (\Exception $e) {
    echo "❌ Unexpected error: {$e->getMessage()}\n";
    exit(1);
}

echo "\n";
echo "📚 Image Best Practices Summary:\n";
echo "   ✓ Use high-quality, relevant images\n";
echo "   ✓ Test multiple variants for each campaign\n";
echo "   ✓ Follow platform dimension guidelines\n";
echo "   ✓ Keep file sizes optimized (< 5MB)\n";
echo "   ✓ Avoid excessive text on images\n";
echo "   ✓ Monitor performance and iterate\n";
echo "   ✓ Use consistent branding across images\n";
echo "   ✓ Optimize for mobile viewing\n";

echo "\n";
echo "🎨 Creative Tips:\n";
echo "   • Use contrasting colors for better visibility\n";
echo "   • Include faces for higher engagement\n";
echo "   • Show products in use (lifestyle shots)\n";
echo "   • Create urgency with visual cues\n";
echo "   • Test emotional vs. product-focused images\n";
