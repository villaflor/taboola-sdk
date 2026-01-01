<?php

declare(strict_types=1);

/**
 * Example 4: Reporting
 *
 * This example demonstrates how to generate various reports:
 * - Campaign summary report
 * - Top campaign content report
 * - Realtime campaign report
 * - Realtime ads report
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Villaflor\Connection\Auth\APIToken;
use Villaflor\TaboolaSDK\Configurations\Reporting\CampaignSummaryConfiguration;
use Villaflor\TaboolaSDK\Configurations\Reporting\TopCampaignContentConfiguration;
use Villaflor\TaboolaSDK\Definitions\CampaignSummaryDimensionDefinition;
use Villaflor\TaboolaSDK\Definitions\CampaignSummaryFilterDefinition;
use Villaflor\TaboolaSDK\Definitions\TopCampaignContentDimensionDefinition;
use Villaflor\TaboolaSDK\Definitions\TopCampaignContentFilterDefinition;
use Villaflor\TaboolaSDK\Endpoints\Reporting;
use Villaflor\TaboolaSDK\TaboolaClient;

// Configuration
$accountId = 'your-account-id';
$accessToken = trim(file_get_contents(__DIR__ . '/token.txt'));

try {
    // Create authenticated client
    $client = new TaboolaClient(new APIToken($accessToken));
    $reporting = new Reporting($client);

    echo "📊 Reporting Examples\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    // Date range for reports (last 30 days)
    $endDate = date('Y-m-d');
    $startDate = date('Y-m-d', strtotime('-30 days'));

    // ═══════════════════════════════════════════════
    // 1. CAMPAIGN SUMMARY REPORT (by Day)
    // ═══════════════════════════════════════════════
    echo "1️⃣  Campaign Summary Report (Daily Breakdown)\n";
    echo "   Period: {$startDate} to {$endDate}\n\n";

    $summaryConfig = new CampaignSummaryConfiguration(
        accountId: $accountId,
        dimension: CampaignSummaryDimensionDefinition::CAMPAIGN_DAY_BREAKDOWN,
        filters: [
            CampaignSummaryFilterDefinition::START_DATE => $startDate,
            CampaignSummaryFilterDefinition::END_DATE => $endDate,
        ]
    );

    $summary = $reporting->getCampaignSummaryReport($summaryConfig);

    echo "   Report Details:\n";
    echo "   • Timezone: {$summary->timezone}\n";
    echo "   • Records: {$summary->recordCount}\n\n";

    echo "   Sample Data (first 5 days):\n";
    echo "   " . str_repeat('─', 70) . "\n";
    printf("   %-12s %-10s %-12s %-10s %-10s\n", 'Date', 'Clicks', 'Impressions', 'CTR', 'Spent');
    echo "   " . str_repeat('─', 70) . "\n";

    foreach (array_slice($summary->results, 0, 5) as $row) {
        $ctr = $row['impressions'] > 0
            ? round($row['clicks'] / $row['impressions'] * 100, 2)
            : 0;

        printf(
            "   %-12s %-10d %-12d %-9.2f%% $%-9.2f\n",
            $row['date'],
            $row['clicks'],
            $row['impressions'],
            $ctr,
            $row['spent']
        );
    }
    echo "\n";

    // ═══════════════════════════════════════════════
    // 2. TOP CAMPAIGN CONTENT REPORT
    // ═══════════════════════════════════════════════
    echo "2️⃣  Top Campaign Content Report\n";
    echo "   (Best performing items)\n\n";

    $topContentConfig = new TopCampaignContentConfiguration(
        accountId: $accountId,
        dimension: TopCampaignContentDimensionDefinition::ITEM_BREAKDOWN,
        filters: [
            TopCampaignContentFilterDefinition::START_DATE => $startDate,
            TopCampaignContentFilterDefinition::END_DATE => $endDate,
        ]
    );

    $topContent = $reporting->getTopCampaignContentReport($topContentConfig);

    echo "   Top 10 Performing Items:\n";
    echo "   " . str_repeat('─', 90) . "\n";
    printf("   %-8s %-40s %-10s %-10s %-8s\n", 'Item ID', 'Title', 'Clicks', 'CPA', 'ROI');
    echo "   " . str_repeat('─', 90) . "\n";

    foreach (array_slice($topContent->results, 0, 10) as $item) {
        $title = strlen($item['title']) > 37
            ? substr($item['title'], 0, 37) . '...'
            : $item['title'];

        printf(
            "   %-8s %-40s %-10d $%-9.2f %-7.1f%%\n",
            $item['item_id'],
            $title,
            $item['clicks'],
            $item['cpa'] ?? 0,
            ($item['roi'] ?? 0) * 100
        );
    }
    echo "\n";

    // ═══════════════════════════════════════════════
    // 3. REALTIME CAMPAIGN REPORT
    // ═══════════════════════════════════════════════
    echo "3️⃣  Realtime Campaign Report\n";
    echo "   (Current performance)\n\n";

    $realtimeConfig = new CampaignSummaryConfiguration(
        accountId: $accountId,
        dimension: CampaignSummaryDimensionDefinition::CAMPAIGN_DAY_BREAKDOWN
    );

    $realtime = $reporting->getRealtimeCampaignReport($realtimeConfig);

    echo "   Live Campaign Performance:\n";
    $totalClicks = 0;
    $totalSpent = 0;

    foreach ($realtime->results as $row) {
        $totalClicks += $row['clicks'] ?? 0;
        $totalSpent += $row['spent'] ?? 0;
    }

    echo "   • Total Clicks (Today): {$totalClicks}\n";
    echo "   • Total Spent (Today): \${$totalSpent}\n";
    echo "   • Avg. Cost Per Click: $" . round($totalClicks > 0 ? $totalSpent / $totalClicks : 0, 2) . "\n";
    echo "\n";

    // ═══════════════════════════════════════════════
    // 4. EXPORT REPORT TO CSV
    // ═══════════════════════════════════════════════
    echo "4️⃣  Exporting report to CSV...\n";

    $csvFile = __DIR__ . '/campaign_summary_' . date('Y-m-d') . '.csv';
    $fp = fopen($csvFile, 'w');

    // Write headers
    if (! empty($summary->results)) {
        fputcsv($fp, array_keys($summary->results[0]));

        // Write data
        foreach ($summary->results as $row) {
            fputcsv($fp, $row);
        }
    }

    fclose($fp);

    echo "   ✅ Report exported to: {$csvFile}\n";
    echo "   Records exported: {$summary->recordCount}\n";
    echo "\n";

    // ═══════════════════════════════════════════════
    // CALCULATE KEY METRICS
    // ═══════════════════════════════════════════════
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📈 Key Performance Indicators (30 days):\n\n";

    $totalImpressions = 0;
    $totalClicks = 0;
    $totalSpent = 0;
    $totalConversions = 0;

    foreach ($summary->results as $row) {
        $totalImpressions += $row['impressions'] ?? 0;
        $totalClicks += $row['clicks'] ?? 0;
        $totalSpent += $row['spent'] ?? 0;
        $totalConversions += $row['conversions'] ?? 0;
    }

    $avgCTR = $totalImpressions > 0
        ? round($totalClicks / $totalImpressions * 100, 2)
        : 0;
    $avgCPC = $totalClicks > 0
        ? round($totalSpent / $totalClicks, 2)
        : 0;
    $avgCPA = $totalConversions > 0
        ? round($totalSpent / $totalConversions, 2)
        : 0;

    echo "   Total Impressions: " . number_format($totalImpressions) . "\n";
    echo "   Total Clicks: " . number_format($totalClicks) . "\n";
    echo "   Average CTR: {$avgCTR}%\n";
    echo "   Total Spent: $" . number_format($totalSpent, 2) . "\n";
    echo "   Average CPC: \${$avgCPC}\n";
    echo "   Total Conversions: " . number_format($totalConversions) . "\n";
    echo "   Average CPA: \${$avgCPA}\n";

    echo "\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "✅ All reports generated successfully!\n";
} catch (\Villaflor\TaboolaSDK\Exceptions\TaboolaException $e) {
    echo "❌ Taboola API Error: {$e->getMessage()}\n";
    exit(1);
} catch (\Exception $e) {
    echo "❌ Unexpected error: {$e->getMessage()}\n";
    exit(1);
}

echo "\n";
echo "📚 Available Report Dimensions:\n";
echo "   Campaign Summary:\n";
echo "   • CAMPAIGN_BREAKDOWN - Overall campaign performance\n";
echo "   • CAMPAIGN_DAY_BREAKDOWN - Daily campaign performance\n";
echo "   • CAMPAIGN_SITE_DAY_BREAKDOWN - By campaign, site, and day\n\n";

echo "   Top Content:\n";
echo "   • ITEM_BREAKDOWN - By individual items\n";
echo "   • ITEM_SITE_DAY_BREAKDOWN - By item, site, and day\n";
