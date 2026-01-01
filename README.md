# Taboola SDK for PHP

[![Tests](https://github.com/villaflor/taboola-sdk/actions/workflows/test.yml/badge.svg)](https://github.com/villaflor/taboola-sdk/actions/workflows/test.yml)
[![Code Quality](https://github.com/villaflor/taboola-sdk/actions/workflows/lint.yml/badge.svg)](https://github.com/villaflor/taboola-sdk/actions/workflows/lint.yml)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/villaflor/taboola-sdk.svg?style=flat-square)](https://packagist.org/packages/villaflor/taboola-sdk)
[![Total Downloads](https://img.shields.io/packagist/dt/villaflor/taboola-sdk.svg?style=flat-square)](https://packagist.org/packages/villaflor/taboola-sdk)

This package provides a modern, type-safe PHP SDK for the Taboola Platform API with comprehensive endpoint coverage.

## Features

- ✅ **Complete API Coverage**: All major Taboola API endpoints
- ✅ **Type-Safe**: Immutable DTOs with strict types
- ✅ **SOLID Principles**: Clean, maintainable architecture
- ✅ **Modern PHP**: PHP 8.3+ with latest features
- ✅ **Production-Ready Examples**: 7 comprehensive usage examples
- ✅ **Well Documented**: Extensive PHPDoc and guides
- ✅ **Error Handling**: Custom exceptions with context
- ✅ **Testing Ready**: Complete fixture system for testing
- ✅ **100% Test Coverage**: Fully tested with realistic fixtures

## Available Endpoints

### Authentication
- Get access token (OAuth 2.0)

### Account Management
- Get account details
- Get advertiser accounts in network
- Get allowed accounts

### Campaigns
- Get all campaigns
- Get single campaign
- Create campaign
- Update campaign
- Delete campaign
- Duplicate campaign
- Bulk update campaigns

### Campaign Items (Ads)
- Get all items
- Get single item
- Create item
- Update item
- Delete item
- Bulk create items
- Bulk update items
- Bulk delete items

### Reporting
- Campaign summary report
- Top campaign content report
- Realtime campaign report
- Realtime ads report

### Images
- Upload image to account
- Get media library taxonomies
- Get images from media library
- Upload to media library

### Targeting
- Get available publishers
- Get blocked publishers
- Update blocked publishers
- Get postal code targeting
- Update postal code targeting
- Get marketplace audience targeting
- Update marketplace audience targeting
- Get contextual targeting
- Update contextual targeting

### Audiences
- Get custom audiences
- Create custom audience
- Get marketplace audiences
- Get lookalike audiences
- Create lookalike audience
- Get contextual segments

### Conversion Tracking
- Get all conversion rules
- Get single conversion rule
- Create conversion rule
- Update conversion rule

### Dictionary/Reference
- Get countries
- Get regions by country
- Get cities by country
- Get postal codes
- Get platforms
- Get operating systems
- Get browsers

## Requirements

- PHP 8.3 or higher
- Taboola API credentials (Client ID, Client Secret, Account ID)

> **Note:** Request your `client_id` and `client_secret` from your Taboola Account Manager. Your `account_id`, as well as your client credentials, are provided during the API onboarding process.

## Installation

You can install the package via composer:

```bash
composer require villaflor/taboola-sdk
```

## Quick Start

Check out the [`examples/`](examples) directory for production-ready code samples:

1. **[Authentication](examples/01-authentication.php)** - OAuth 2.0 token flow
2. **[Campaign Management](examples/02-campaign-management.php)** - Complete CRUD operations
3. **[Bulk Operations](examples/03-bulk-operations.php)** - High-performance batch updates
4. **[Reporting](examples/04-reporting.php)** - Analytics and data export
5. **[Targeting Setup](examples/05-targeting-setup.php)** - Advanced targeting configuration
6. **[Image Upload](examples/06-image-upload.php)** - Media library management
7. **[Audience Creation](examples/07-audience-creation.php)** - Custom audience targeting

See the [Examples README](examples/README.md) for detailed documentation on running and using these examples.

## Usage

### Authentication

First, authenticate with the Taboola API to obtain an access token:

```php
use Villaflor\Connection\Auth\APIToken;
use Villaflor\Connection\Auth\None;
use Villaflor\TaboolaSDK\Configurations\AuthenticationConfiguration;
use Villaflor\TaboolaSDK\Endpoints\Authentication;
use Villaflor\TaboolaSDK\TaboolaClient;

$clientId = 'your-client-id';
$clientSecret = 'your-client-secret';
$accountId = 'your-account-id';

// Get access token
$authEndpoint = new Authentication(new TaboolaClient(new None()));
$response = $authEndpoint->getAccessToken(
    new AuthenticationConfiguration($clientId, $clientSecret)
);

// Access token is now type-safe with AuthenticationResponse DTO
$accessToken = $response->accessToken;
$expiresIn = $response->expiresIn;
$tokenType = $response->tokenType;
```

### Working with Accounts

```php
use Villaflor\TaboolaSDK\Configurations\Account\AccountDetailsConfiguration;
use Villaflor\TaboolaSDK\Configurations\Account\AdvertiserAccountsInNetworkConfiguration;
use Villaflor\TaboolaSDK\Configurations\Account\AllowedAccountsConfiguration;
use Villaflor\TaboolaSDK\Endpoints\Account;

// Create authenticated client
$client = new TaboolaClient(new APIToken($accessToken));
$account = new Account($client);

// Get account details - Returns AccountResponse DTO
$details = $account->getAccountDetails(new AccountDetailsConfiguration());
$accountData = $details->body;

// Get advertiser accounts in network - Returns CollectionResponse DTO
$advertisers = $account->getAdvertiserAccountsInNetwork(
    new AdvertiserAccountsInNetworkConfiguration($accountId)
);
$results = $advertisers->results;
$metadata = $advertisers->metadata;

// Get allowed accounts - Returns CollectionResponse DTO
$allowed = $account->getAllowedAccounts(new AllowedAccountsConfiguration());
```

### Managing Campaigns

```php
use Villaflor\TaboolaSDK\Configurations\Campaigns\AllCampaignsConfiguration;
use Villaflor\TaboolaSDK\Definitions\AllCampaignsFilterDefinition;
use Villaflor\TaboolaSDK\Endpoints\Campaigns;

$campaigns = new Campaigns($client);

// Get all campaigns - Returns CollectionResponse DTO
$response = $campaigns->getAllCampaigns(
    new AllCampaignsConfiguration(
        accountId: $accountId,
        filters: [
            AllCampaignsFilterDefinition::FETCH_LEVEL =>
                AllCampaignsFilterDefinition::FETCH_LEVEL_RECENT_AND_PAUSED_OPTIONS
        ]
    )
);

$campaignList = $response->results;
$metadata = $response->metadata;
```

### Generating Reports

```php
use Villaflor\TaboolaSDK\Configurations\Reporting\CampaignSummaryConfiguration;
use Villaflor\TaboolaSDK\Configurations\Reporting\TopCampaignContentConfiguration;
use Villaflor\TaboolaSDK\Definitions\CampaignSummaryDimensionDefinition;
use Villaflor\TaboolaSDK\Definitions\CampaignSummaryFilterDefinition;
use Villaflor\TaboolaSDK\Definitions\TopCampaignContentDimensionDefinition;
use Villaflor\TaboolaSDK\Definitions\TopCampaignContentFilterDefinition;
use Villaflor\TaboolaSDK\Endpoints\Reporting;

$reporting = new Reporting($client);

// Campaign summary report - Returns ReportResponse DTO
$summary = $reporting->getCampaignSummaryReport(
    new CampaignSummaryConfiguration(
        accountId: $accountId,
        dimension: CampaignSummaryDimensionDefinition::CAMPAIGN_DAY_BREAKDOWN,
        filters: [
            CampaignSummaryFilterDefinition::START_DATE => '2021-08-01',
            CampaignSummaryFilterDefinition::END_DATE => '2021-08-31',
        ]
    )
);

// Access type-safe response properties
$timezone = $summary->timezone;
$results = $summary->results;
$recordCount = $summary->recordCount;
$metadata = $summary->metadata;

// Top campaign content report - Returns ReportResponse DTO
$topContent = $reporting->getTopCampaignContentReport(
    new TopCampaignContentConfiguration(
        accountId: $accountId,
        dimension: TopCampaignContentDimensionDefinition::ITEM_BREAKDOWN,
        filters: [
            TopCampaignContentFilterDefinition::START_DATE => '2021-08-01',
            TopCampaignContentFilterDefinition::END_DATE => '2021-08-31',
        ]
    )
);
```

## Error Handling

The SDK uses type-safe exceptions for better error handling:

```php
use Villaflor\TaboolaSDK\Exceptions\JsonDecodeException;
use Villaflor\TaboolaSDK\Exceptions\TaboolaException;

try {
    $response = $authEndpoint->getAccessToken($config);
} catch (JsonDecodeException $e) {
    // Handle JSON decoding errors
    echo "Failed to decode API response: " . $e->getMessage();
} catch (TaboolaException $e) {
    // Handle other Taboola SDK errors
    echo "SDK Error: " . $e->getMessage();
}
```

## Testing

The SDK includes a comprehensive test suite with 100% code coverage and realistic API response fixtures.

### Run Tests

```bash
composer test
```

### Generate Coverage Report

```bash
composer test-coverage
```

### Run Static Analysis

```bash
composer analyse
```

### Format Code

```bash
composer format
```

### Testing with Fixtures

The SDK includes 47 realistic API response fixtures based on official Taboola documentation. You can use these in your own tests:

```php
use function Tests\loadFixture;
use function Tests\mockResponseFromFixture;
use function Tests\mockResponse;

// Load fixture data as array
$data = loadFixture('Campaigns/single_campaign.json');

// Create mock response from fixture
$response = mockResponseFromFixture('Campaigns/single_campaign.json');

// Create mock response from array
$response = mockResponse(['status' => 'success']);
```

See the [Fixtures README](tests/Fixtures/README.md) for complete documentation.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mark Anthony Villaflor](https://github.com/villaflor)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.