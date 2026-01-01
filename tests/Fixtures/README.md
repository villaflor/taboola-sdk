# Test Fixtures

This directory contains realistic test fixtures based on actual Taboola API response structures from the [official API documentation](https://developers.taboola.com/backstage-api/reference/welcome).

## Directory Structure

```
Fixtures/
├── Authentication/         # OAuth 2.0 authentication responses
├── Campaigns/             # Campaign CRUD operation responses
├── CampaignItems/         # Campaign item operation responses
├── Reporting/             # Report API responses
├── Audiences/             # Audience management responses
├── Dictionary/            # Dictionary/lookup data responses
├── Images/                # Image upload and media library responses
├── Targeting/             # Targeting configuration responses
└── ConversionTracking/    # Conversion tracking responses
```

## Usage

### Loading Fixtures

Use the global `loadFixture()` helper function to load fixture data:

```php
// Load fixture as array
$data = loadFixture('Campaigns/all_campaigns.json');

// Returns:
// [
//     'results' => [...],
//     'metadata' => [...]
// ]
```

### Creating Mock Responses

Use the `mockResponseFromFixture()` helper to create PSR-7 response mocks:

```php
it('can get all campaigns', function () {
    $config = new AllCampaignsConfiguration($this->accountId);

    // Load fixture and create mock response in one step
    $response = mockResponseFromFixture('Campaigns/all_campaigns.json');

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getAllCampaigns($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class);
});
```

### Alternative: Manual Mock Creation

You can also load fixtures and create responses separately:

```php
// Load the fixture data
$fixtureData = loadFixture('Campaigns/single_campaign.json');

// Create mock response
$response = mockResponse($fixtureData);

// Or create from JSON string
$response = mockResponse(json_encode($fixtureData));
```

## Fixture Format

All fixtures are JSON files containing realistic API response structures:

### Collection Response Format

```json
{
  "results": [
    {
      "id": "123",
      "name": "Campaign 1",
      ...
    }
  ],
  "metadata": {
    "total_results": 1
  }
}
```

### Single Entity Response Format

```json
{
  "id": "123",
  "name": "Campaign 1",
  "status": "RUNNING",
  ...
}
```

### Report Response Format

```json
{
  "timezone": "EST",
  "results": [...],
  "recordCount": 10,
  "record_count": 10,
  "metadata": {
    "total": 10,
    "static_fields": [...]
  }
}
```

## Available Fixtures

### Authentication

- `Authentication/access_token.json` - OAuth token response

### Campaigns

- `Campaigns/all_campaigns.json` - List of campaigns
- `Campaigns/single_campaign.json` - Single campaign details
- `Campaigns/created_campaign.json` - Newly created campaign
- `Campaigns/bulk_updated_campaigns.json` - Bulk update response

### Campaign Items

- `CampaignItems/all_items.json` - List of campaign items
- `CampaignItems/single_item.json` - Single item details
- `CampaignItems/bulk_created_items.json` - Bulk create response

### Reporting

- `Reporting/campaign_summary.json` - Campaign summary report
- `Reporting/top_campaign_content.json` - Top content report
- `Reporting/realtime_campaign.json` - Realtime campaign data

### Dictionary

- `Dictionary/countries.json` - List of countries
- `Dictionary/regions.json` - List of regions/states
- `Dictionary/platforms.json` - List of platforms

### Images

- `Images/uploaded_image.json` - Single uploaded image
- `Images/media_library.json` - Media library listing

### Audiences

- `Audiences/all_audiences.json` - List of custom audiences
- `Audiences/marketplace_audiences.json` - Marketplace audience options

### Targeting

- `Targeting/publishers.json` - Available publishers

### Conversion Tracking

- `ConversionTracking/conversion_rules.json` - Conversion tracking rules

## Helper Functions

### `loadFixture(string $path): array`

Loads a fixture file and returns its contents as an associative array.

**Parameters:**
- `$path` - Path relative to `tests/Fixtures/` directory

**Returns:** Array representation of the JSON fixture

**Throws:** `RuntimeException` if file not found or invalid JSON

**Example:**
```php
$data = loadFixture('Campaigns/all_campaigns.json');
```

### `mockResponseFromFixture(string $fixturePath): ResponseInterface`

Creates a PSR-7 response mock from a fixture file.

**Parameters:**
- `$fixturePath` - Path relative to `tests/Fixtures/` directory

**Returns:** Mocked PSR-7 ResponseInterface

**Example:**
```php
$response = mockResponseFromFixture('Campaigns/single_campaign.json');
```

### `mockResponse(string|array $data): ResponseInterface`

Creates a PSR-7 response mock from array or string data.

**Parameters:**
- `$data` - Array or JSON string

**Returns:** Mocked PSR-7 ResponseInterface

**Example:**
```php
// From array
$response = mockResponse(['id' => '123', 'name' => 'Test']);

// From JSON string
$response = mockResponse('{"id": "123", "name": "Test"}');
```

## Adding New Fixtures

1. **Create the fixture file:**
   ```bash
   touch tests/Fixtures/YourCategory/your_fixture.json
   ```

2. **Add realistic data from API docs:**
   ```json
   {
     "results": [...],
     "metadata": {...}
   }
   ```

3. **Use in tests:**
   ```php
   $response = mockResponseFromFixture('YourCategory/your_fixture.json');
   ```

## Best Practices

1. **Use realistic data** - Base fixtures on actual API responses from documentation
2. **Include all relevant fields** - Don't omit fields even if they're nullable
3. **Maintain consistency** - Use consistent IDs and values across related fixtures
4. **Document special cases** - Add comments in fixtures for complex scenarios
5. **Keep fixtures up-to-date** - Update when API changes

## Response Data Types

When using fixtures with Taboola SDK, remember:

- **Collection responses** (`CollectionResponse`) - Results array contains `stdClass` objects
- **Single entity responses** - Return `stdClass` object directly
- **Report responses** (`ReportResponse`) - Special handling for `recordCount`/`record_count`

### Accessing Collection Results

```php
$result = $endpoint->getAllCampaigns($config);

// Results is an array of stdClass objects
expect($result->results)->toBeArray();
expect($result->results[0])->toBeInstanceOf(stdClass::class);

// Access properties with object notation
$campaign = $result->results[0];
expect($campaign->id)->toBe('5750752');
expect($campaign->name)->toBe('Demo Campaign 1');
```

### Accessing Single Entity Results

```php
$result = $endpoint->getCampaign($config);

// Result is a stdClass object
expect($result)->toBeInstanceOf(stdClass::class);
expect($result->id)->toBe('5750752');
expect($result->name)->toBe('Demo Campaign 1');
```

## Troubleshooting

### Fixture File Not Found

```
RuntimeException: Fixture file not found: /path/to/fixture.json
```

**Solution:** Verify the path is correct relative to `tests/Fixtures/`

### Invalid JSON

```
RuntimeException: Invalid JSON in fixture file: Unexpected token
```

**Solution:** Validate JSON syntax using `composer format` or an online validator

### Wrong Data Type

```
Failed asserting that stdClass is of type array
```

**Solution:** Collection results contain `stdClass` objects, use object notation (`->property`) not array notation (`['key']`)

## References

- [Taboola API Documentation](https://developers.taboola.com/backstage-api/reference/welcome)
- [Get All Campaigns](https://developers.taboola.com/backstage-api/reference/get-all-campaigns)
- [Campaign Summary Report](https://developers.taboola.com/backstage-api/reference/campaign-summary-report)
- [Create Campaign](https://developers.taboola.com/backstage-api/reference/create-a-campaign)

---

**Last Updated:** 2025-12-30
**Fixtures Count:** 17+ files
**Coverage:** All major API endpoints
