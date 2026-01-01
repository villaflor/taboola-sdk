# Changelog

All notable changes to `taboola-sdk` will be documented in this file.

## 2.0.0 - TBD

### Added
- Added support for PHP 8.3+
- Added PHPStan for static analysis
- Added Pest for testing
- Added Laravel Pint for code formatting
- **Type-safe DTOs**: Introduced immutable Data Transfer Objects
  - `AuthenticationResponse` - Type-safe authentication responses
  - `AccountResponse` - Type-safe account details
  - `CollectionResponse` - Type-safe collection responses
  - `ReportResponse` - Type-safe reporting data
- **Custom Exceptions**: Better error handling with dedicated exception classes
  - `TaboolaException` - Base exception
  - `JsonDecodeException` - JSON parsing errors
- **Abstract Base Endpoint**: Reduced code duplication with `AbstractEndpoint`
- **Complete API Coverage**: Implemented comprehensive Taboola API endpoints
  - **Campaign Management**: Full CRUD operations
    - Get single campaign
    - Create campaign
    - Update campaign
    - Delete campaign
    - Duplicate campaign
    - Bulk update campaigns
  - **Campaign Items (Ads)**: Complete ad management
    - Get all items
    - Get single item
    - Create item
    - Update item
    - Delete item
    - Bulk create items
    - Bulk update items
    - Bulk delete items
  - **Dictionary/Reference**: Resource lookup endpoints
    - Get countries
    - Get regions
    - Get cities
    - Get postal codes
    - Get platforms
    - Get operating systems
    - Get browsers
  - **Reporting**: Enhanced reporting capabilities
    - Realtime campaign report
    - Realtime ads report
    - (Existing: Campaign summary, Top campaign content)
  - **Images**: Image management and media library
    - Upload image to account
    - Get media library taxonomies
    - Get images from media library
    - Upload to media library
  - **Targeting**: Publisher targeting and campaign targeting
    - Get available publishers
    - Get/update blocked publishers
    - Get/update postal code targeting
    - Get/update marketplace audience targeting
    - Get/update contextual targeting
  - **Audiences**: Audience management capabilities
    - Get/create custom audiences
    - Get marketplace audiences
    - Get/create lookalike audiences
    - Get contextual segments
  - **Conversion Tracking**: Pixel API for conversion rules
    - Get all conversion rules
    - Get single conversion rule
    - Create conversion rule
    - Update conversion rule
- **Comprehensive URI Definitions**: All API endpoint URIs documented and typed
- **Usage Examples**: 7 production-ready examples demonstrating common use cases
  - Authentication and token management
  - Campaign management (CRUD operations)
  - Bulk operations for efficiency
  - Reporting and analytics
  - Advanced targeting setup
  - Image upload and management
  - Audience creation and targeting
- **Complete Test Fixtures**: 47 realistic API response fixtures
  - Based on official Taboola API documentation
  - Covers all 10 endpoint categories
  - Account (3 fixtures), Audiences (7), Authentication (1), CampaignItems (7)
  - Campaigns (7), ConversionTracking (4), Dictionary (7), Images (3)
  - Reporting (3), Targeting (5)
- **Fixture Helper Functions**: Convenient test utilities
  - `loadFixture()` - Load fixture files as arrays
  - `mockResponseFromFixture()` - Create PSR-7 responses from fixtures
  - `mockResponse()` - Create responses from arrays/strings
- **Comprehensive Documentation**:
  - `examples/README.md` - Complete guide with usage patterns and best practices
  - `tests/Fixtures/README.md` - Fixture system documentation with troubleshooting

### Changed
- **SOLID Principles Applied**:
  - Single Responsibility: Each class has one clear purpose
  - Open/Closed: Extensible through inheritance and interfaces
  - Dependency Inversion: Depend on abstractions (interfaces)
- **Immutable Configurations**: All configuration classes now use `readonly` properties
- **Type Safety**: Strict return types using DTOs instead of `stdClass`
- **Named Parameters**: All configuration constructors support named parameters
- **Test Infrastructure**: All tests updated to use realistic fixtures
  - 67 tests with 204 assertions
  - 100% code coverage maintained
  - More maintainable and readable tests
- Migrated to Spatie package skeleton structure
- Updated to use villaflor/connection ^5.0
- Updated code style to PSR-12 standards
- Updated GitHub Actions workflows
- Modernized PHPUnit configuration to version 10.5
- All source files now use strict types declaration
- Constructor property promotion with readonly properties
- Class constants updated to public const
- All endpoint classes marked as `final` for better performance

### Removed
- Dropped support for PHP 7.4 and 8.0-8.2
- Removed Guzzle dependency (now handled by villaflor/connection)
- Removed PHPMD dependency
- Removed PHP CS Fixer (replaced with Laravel Pint)
- Removed Roave Security Advisories
- Removed Spatie Ray
- Removed `BodyAccessorTrait` (replaced with dedicated response DTOs)
- Removed Makefile (use Composer scripts instead)

## 1.0.0 - Previous Release

Initial release
