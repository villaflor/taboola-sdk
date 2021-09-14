<?php

namespace Villaflor\TaboolaSDK\Definitions;

final class URI
{
    const BASE_URI = 'https://backstage.taboola.com/backstage/';
    const AUTH_URI = 'oauth/token';
    const API_URI = 'api/1.0/';

    const ACCOUNT_DETAILS_URI = 'users/current/account';
    const ACCOUNT_ADVERTISER_ACCOUNTS_IN_NETWORK_URI = '{account_id}/advertisers';
    const ACCOUNT_ALLOWED_ACCOUNTS_URI = 'users/current/allowed-accounts';

    const CAMPAIGN_ALL_CAMPAIGNS_URI = '{account_id}/campaigns';

    const REPORT_CAMPAIGN_SUMMARY_URI = '{account_id}/reports/campaign-summary/dimensions/{dimension}';
    const REPORT_TOP_CAMPAIGN_CONTENT_URI = '{account_id}/reports/top-campaign-content/dimensions/{dimension}';
}
