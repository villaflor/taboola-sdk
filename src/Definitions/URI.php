<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Definitions;

final class URI
{
    // Base URIs
    public const BASE_URI = 'https://backstage.taboola.com/backstage/';
    public const AUTH_URI = 'oauth/token';
    public const API_URI = 'api/1.0/';

    // Account Management
    public const ACCOUNT_DETAILS_URI = 'users/current/account';
    public const ACCOUNT_ADVERTISER_ACCOUNTS_IN_NETWORK_URI = '{account_id}/advertisers';
    public const ACCOUNT_ALLOWED_ACCOUNTS_URI = 'users/current/allowed-accounts';

    // Campaigns
    public const CAMPAIGN_ALL_CAMPAIGNS_URI = '{account_id}/campaigns';
    public const CAMPAIGN_SINGLE_URI = '{account_id}/campaigns/{campaign_id}';
    public const CAMPAIGN_CREATE_URI = '{account_id}/campaigns';
    public const CAMPAIGN_UPDATE_URI = '{account_id}/campaigns/{campaign_id}';
    public const CAMPAIGN_DELETE_URI = '{account_id}/campaigns/{campaign_id}';
    public const CAMPAIGN_DUPLICATE_URI = '{account_id}/campaigns/{campaign_id}/duplicate';
    public const CAMPAIGN_BULK_UPDATE_URI = '{account_id}/campaigns/mass-update';
    public const CAMPAIGN_REACH_ESTIMATOR_URI = '{account_id}/campaigns/reach-estimator';

    // Campaign Items (Ads)
    public const CAMPAIGN_ITEM_ALL_URI = '{account_id}/campaigns/{campaign_id}/items';
    public const CAMPAIGN_ITEM_SINGLE_URI = '{account_id}/campaigns/{campaign_id}/items/{item_id}';
    public const CAMPAIGN_ITEM_CREATE_URI = '{account_id}/campaigns/{campaign_id}/items';
    public const CAMPAIGN_ITEM_UPDATE_URI = '{account_id}/campaigns/{campaign_id}/items/{item_id}';
    public const CAMPAIGN_ITEM_DELETE_URI = '{account_id}/campaigns/{campaign_id}/items/{item_id}';
    public const CAMPAIGN_ITEM_BULK_CREATE_URI = '{account_id}/campaigns/{campaign_id}/items/mass-create';
    public const CAMPAIGN_ITEM_BULK_CREATE_ACROSS_CAMPAIGNS_URI = '{account_id}/campaigns/items';
    public const CAMPAIGN_ITEM_BULK_UPDATE_URI = '{account_id}/campaigns/items/mass-update';
    public const CAMPAIGN_ITEM_BULK_DELETE_URI = '{account_id}/campaigns/items';

    // Reporting
    public const REPORT_CAMPAIGN_SUMMARY_URI = '{account_id}/reports/campaign-summary/dimensions/{dimension}';
    public const REPORT_TOP_CAMPAIGN_CONTENT_URI = '{account_id}/reports/top-campaign-content/dimensions/{dimension}';
    public const REPORT_REALTIME_CAMPAIGN_URI = '{account_id}/reports/campaign-realtime/dimensions/{dimension}';
    public const REPORT_REALTIME_ADS_URI = '{account_id}/reports/realtime-ads/dimensions/{dimension}';

    // Dictionary/Reference
    public const DICTIONARY_COUNTRIES_URI = 'resources/countries';
    public const DICTIONARY_REGIONS_URI = 'resources/countries/{country_code}/regions';
    public const DICTIONARY_CITIES_URI = 'resources/countries/{country_code}/cities';
    public const DICTIONARY_POSTAL_CODES_URI = 'resources/countries/{country_code}/postal-codes';
    public const DICTIONARY_PLATFORMS_URI = 'resources/platforms';
    public const DICTIONARY_OS_URI = 'resources/os';
    public const DICTIONARY_BROWSERS_URI = 'resources/browsers';
    public const DICTIONARY_OS_FAMILIES_URI = 'resources/os-families';
    public const DICTIONARY_BROWSER_FAMILIES_URI = 'resources/browser-families';

    // Targeting
    public const TARGETING_PUBLISHERS_URI = '{account_id}/targeting/publishers';
    public const TARGETING_BLOCKED_PUBLISHERS_URI = '{account_id}/blocked_publishers';
    public const TARGETING_POSTAL_CODES_URI = '{account_id}/campaigns/{campaign_id}/targeting/postal_code';
    public const TARGETING_MARKETPLACE_AUDIENCE_URI = '{account_id}/campaigns/{campaign_id}/targeting/marketplace_audience';
    public const TARGETING_CONTEXTUAL_URI = '{account_id}/campaigns/{campaign_id}/targeting/contextual';

    // Images
    public const IMAGE_UPLOAD_URI = '{account_id}/images';
    public const IMAGE_LIBRARY_TAXONOMIES_URI = 'media-library/taxonomies';
    public const IMAGE_LIBRARY_GET_URI = 'media-library/images';
    public const IMAGE_LIBRARY_UPLOAD_URI = '{account_id}/images/media-library';

    // Audiences
    public const AUDIENCE_CUSTOM_ALL_URI = '{account_id}/audiences/custom';
    public const AUDIENCE_CUSTOM_CREATE_URI = '{account_id}/audiences/custom';
    public const AUDIENCE_MARKETPLACE_URI = 'resources/audiences/marketplace';
    public const AUDIENCE_LOOKALIKE_URI = '{account_id}/audiences/lookalike';
    public const AUDIENCE_CONTEXTUAL_SEGMENTS_URI = 'resources/contextual-segments';

    // Conversion Tracking
    public const CONVERSION_RULES_ALL_URI = '{account_id}/conversions';
    public const CONVERSION_RULE_SINGLE_URI = '{account_id}/conversions/{conversion_id}';
    public const CONVERSION_RULE_CREATE_URI = '{account_id}/conversions';
    public const CONVERSION_RULE_UPDATE_URI = '{account_id}/conversions/{conversion_id}';
}
