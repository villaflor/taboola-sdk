# Taboola SDK - Usage Examples

This directory contains comprehensive examples demonstrating how to use the Taboola SDK for common advertising operations.

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Getting Started](#getting-started)
3. [Examples Overview](#examples-overview)
4. [Running Examples](#running-examples)
5. [Common Patterns](#common-patterns)
6. [Troubleshooting](#troubleshooting)

---

## Prerequisites

Before running these examples, ensure you have:

- **PHP 8.3+** installed
- **Composer** installed
- **Taboola API credentials** (client ID and client secret)
- **Valid Taboola account** with appropriate permissions

### Installation

```bash
composer require villaflor/taboola-sdk
```

---

## Getting Started

### 1. Obtain API Credentials

Contact your Taboola Account Manager to request:
- Client ID
- Client Secret
- Account ID(s)

### 2. Authenticate

Run the authentication example first to obtain an access token:

```bash
php examples/01-authentication.php
```

Update the file with your credentials:
```php
$clientId = 'your-client-id';
$clientSecret = 'your-client-secret';
```

This will create a `token.txt` file that other examples will use.

### 3. Configure Examples

Each example file has configuration variables at the top:

```php
$accountId = 'your-account-id';
$campaignId = 'your-campaign-id'; // Where applicable
$accessToken = trim(file_get_contents(__DIR__ . '/token.txt'));
```

Update these with your actual values.

---

## Examples Overview

### 01. Authentication
**File:** `01-authentication.php`

Demonstrates OAuth 2.0 authentication flow.

**What you'll learn:**
- How to authenticate with the Taboola API
- Token management and expiration
- Secure token storage

**Key endpoints:**
- `POST /oauth/token`

---

### 02. Campaign Management
**File:** `02-campaign-management.php`

Complete CRUD operations for campaigns.

**What you'll learn:**
- List all campaigns with filters
- Get single campaign details
- Create new campaigns
- Update campaign settings
- Duplicate campaigns
- Delete campaigns

**Key endpoints:**
- `GET /backstage/api/1.0/{account}/campaigns`
- `POST /backstage/api/1.0/{account}/campaigns`
- `PATCH /backstage/api/1.0/{account}/campaigns/{id}`
- `DELETE /backstage/api/1.0/{account}/campaigns/{id}`

**Sample operations:**
- 6 different campaign operations
- Error handling patterns
- Configuration best practices

---

### 03. Bulk Operations
**File:** `03-bulk-operations.php`

High-performance bulk operations for efficiency.

**What you'll learn:**
- Bulk update campaigns
- Bulk create campaign items (5+ items)
- Bulk update items
- Bulk delete items
- Performance optimization

**Key benefits:**
- Up to 10x faster than individual calls
- Reduced API quota usage
- Ideal for managing 50+ items

**Performance comparison:**
- Individual: 5 items = 5 API calls (~2.5s)
- Bulk: 5 items = 1 API call (~0.5s)
- **Savings:** 80% fewer API calls, 5x faster

---

### 04. Reporting
**File:** `04-reporting.php`

Generate comprehensive reports and analytics.

**What you'll learn:**
- Campaign summary reports (daily breakdown)
- Top content performance reports
- Realtime campaign reports
- CSV export functionality
- KPI calculations (CTR, CPC, CPA)

**Report types:**
1. **Campaign Summary** - Daily performance breakdown
2. **Top Campaign Content** - Best performing items
3. **Realtime Reports** - Current performance data
4. **Custom Exports** - CSV format for external analysis

**Metrics covered:**
- Impressions, clicks, CTR
- Spend, CPC, CPA
- Conversions, ROI
- Time-based trends

---

### 05. Targeting Setup
**File:** `05-targeting-setup.php`

Advanced targeting configuration.

**What you'll learn:**
- Publisher targeting (premium sites)
- Geographic targeting (countries, regions, cities)
- Postal code targeting
- Marketplace audience targeting
- Contextual targeting
- Platform and device targeting

**Targeting types:**
1. **Publisher** - Include/exclude specific sites
2. **Geographic** - Country, state, city, postal code
3. **Audience** - Pre-built marketplace segments
4. **Contextual** - Content-based targeting
5. **Platform** - Desktop, mobile, tablet
6. **OS** - Android, iOS, Windows, macOS

**Best practices:**
- Start broad, narrow based on performance
- A/B test different targeting combinations
- Monitor reach vs. performance balance

---

### 06. Image Upload & Management
**File:** `06-image-upload.php`

Media library and image operations.

**What you'll learn:**
- Upload images for campaigns
- Browse media library
- Manage uploaded images
- Use images in campaign items
- A/B test image variants
- Batch image operations

**Image specifications:**
- **Dimensions:** 1200x628px (recommended)
- **Format:** JPG, PNG, GIF
- **Max size:** 5MB
- **Min dimensions:** 600x400px

**Optimization tips:**
- Test 3-5 variants per item
- Monitor CTR by image
- Use high-quality, relevant images
- Follow 20% text rule

---

### 07. Audience Creation
**File:** `07-audience-creation.php`

Custom audience management and targeting.

**What you'll learn:**
- Create custom audiences from CRM data
- Upload customer lists (email, phone)
- Create lookalike audiences
- Browse marketplace audiences
- Work with contextual segments
- Audience optimization strategies

**Audience types:**
1. **Custom** - Your customer data
2. **Lookalike** - Similar to your customers
3. **Marketplace** - Pre-built 3rd party segments
4. **Contextual** - Content-based, privacy-friendly

**Use cases:**
- Retargeting website visitors
- Customer acquisition with lookalikes
- Interest-based targeting
- Behavioral segmentation

**Strategy guide:**
- Minimum audience size: 1,000+ members
- Test similarity scores (1%, 5%, 10%)
- Refresh data weekly/monthly
- Create exclusion lists for converters

---

## Running Examples

### Option 1: Run Individual Examples

```bash
# First, authenticate
php examples/01-authentication.php

# Then run any example
php examples/02-campaign-management.php
php examples/03-bulk-operations.php
php examples/04-reporting.php
# ... etc
```

### Option 2: Run All Examples (Sequential)

```bash
#!/bin/bash
for example in examples/*.php; do
    echo "Running $example..."
    php "$example"
    echo "---"
done
```

### Option 3: Interactive Mode

Modify examples to prompt for input:

```php
echo "Enter Account ID: ";
$accountId = trim(fgets(STDIN));
```

---

## Common Patterns

### 1. Authentication Pattern

```php
use Villaflor\Connection\Auth\APIToken;
use Villaflor\TaboolaSDK\TaboolaClient;

$accessToken = trim(file_get_contents(__DIR__ . '/token.txt'));
$client = new TaboolaClient(new APIToken($accessToken));
```

### 2. Error Handling Pattern

```php
try {
    // API operations
} catch (\Villaflor\TaboolaSDK\Exceptions\TaboolaException $e) {
    echo "❌ Taboola API Error: {$e->getMessage()}\n";
    exit(1);
} catch (\Exception $e) {
    echo "❌ Unexpected error: {$e->getMessage()}\n";
    exit(1);
}
```

### 3. Configuration Pattern

```php
use Villaflor\TaboolaSDK\Configurations\Campaigns\SingleCampaignConfiguration;

$config = new SingleCampaignConfiguration(
    accountId: $accountId,
    campaignId: $campaignId
);

$campaign = $campaigns->getCampaign($config);
```

### 4. Bulk Operations Pattern

```php
$items = [
    ['id' => '123', 'cpc' => 0.50],
    ['id' => '456', 'cpc' => 0.60],
    // ... more items
];

$result = $endpoint->bulkUpdate($config, $items);
```

### 5. Pagination Pattern

```php
$config = new AllCampaignsConfiguration(
    accountId: $accountId,
    filters: [
        'limit' => 50,
        'offset' => 0,
    ]
);

do {
    $result = $campaigns->getAllCampaigns($config);
    // Process results...
    $config->filters['offset'] += 50;
} while (count($result->results) === 50);
```

---

## Troubleshooting

### Common Issues

#### 1. Authentication Errors

**Error:** `401 Unauthorized`

**Solution:**
- Verify client ID and secret are correct
- Check if token has expired (default: 12 hours)
- Re-run `01-authentication.php` to get fresh token

#### 2. Token Expiration

**Error:** `Invalid or expired token`

**Solution:**
```php
// Check token expiration before use
$tokenAge = time() - filemtime(__DIR__ . '/token.txt');
if ($tokenAge > 43200) { // 12 hours
    // Re-authenticate
}
```

#### 3. Rate Limiting

**Error:** `429 Too Many Requests`

**Solution:**
```php
// Add delay between requests
usleep(500000); // 0.5 second delay

// Use bulk operations instead of individual calls
```

#### 4. Invalid Account ID

**Error:** `Account not found`

**Solution:**
- Verify account ID from Taboola dashboard
- Ensure your credentials have access to this account
- Check account permissions with your account manager

#### 5. Campaign Not Found

**Error:** `Campaign ID does not exist`

**Solution:**
- List all campaigns first to get valid IDs
- Verify campaign belongs to the correct account
- Check campaign wasn't deleted

#### 6. Image Upload Failures

**Error:** `Invalid image format`

**Solution:**
- Verify image meets specifications (JPG, PNG, GIF)
- Check file size < 5MB
- Ensure minimum dimensions (600x400px)
- Validate URL is publicly accessible

#### 7. Targeting Errors

**Error:** `Invalid targeting configuration`

**Solution:**
- Check country codes are valid ISO codes
- Verify publisher IDs exist in your account
- Ensure audience IDs are valid and active
- Validate postal codes for the target country

---

## Best Practices

### 1. Security
- Never commit `token.txt` to version control
- Store credentials in environment variables
- Use `.gitignore` for sensitive files
- Rotate tokens regularly

### 2. Performance
- Use bulk operations for 5+ items
- Implement retry logic with exponential backoff
- Cache frequently accessed data
- Monitor API quota usage

### 3. Error Handling
- Always wrap API calls in try-catch
- Log errors for debugging
- Implement graceful degradation
- Provide user-friendly error messages

### 4. Testing
- Use test campaigns for experimentation
- Clean up test data after examples
- Validate data before API calls
- Monitor spend on test campaigns

### 5. Monitoring
- Track API response times
- Monitor error rates
- Set up alerts for failures
- Log all operations for audit trails

---

## Additional Resources

### Documentation
- [Taboola API Documentation](https://developers.taboola.com/)
- [SDK Repository](https://github.com/villaflor/taboola-sdk)
- [Changelog](../CHANGELOG.md)

### Support
- **Issues:** [GitHub Issues](https://github.com/villaflor/taboola-sdk/issues)
- **Taboola Support:** Contact your account manager
- **Community:** Taboola Developer Community

### Related Examples
- [Laravel Integration](#) (coming soon)
- [Symfony Bundle](#) (coming soon)
- [Async Processing](#) (coming soon)

---

## Example Progression

For optimal learning, run examples in this order:

1. **01-authentication.php** - Get your token (required for all others)
2. **02-campaign-management.php** - Learn CRUD basics
3. **05-targeting-setup.php** - Configure targeting first
4. **06-image-upload.php** - Prepare creative assets
5. **03-bulk-operations.php** - Scale your operations
6. **07-audience-creation.php** - Advanced audience targeting
7. **04-reporting.php** - Monitor and optimize

---

## Contributing

Found an issue or want to add more examples?

1. Fork the repository
2. Create your feature branch
3. Add your example following the established format
4. Update this README
5. Submit a pull request

---

## License

This SDK is open-source software licensed under the MIT license.

---

**Last Updated:** 2025-12-30
**SDK Version:** 2.0.0
**Examples:** 7 comprehensive use cases
