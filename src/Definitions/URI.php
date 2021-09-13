<?php

namespace Villaflor\TaboolaSDK\Definitions;

final class URI
{
    const BASE_URI  = 'https://backstage.taboola.com/backstage/';
    const AUTH_URI  = 'oauth/token/';
    const API_URI   = 'api/1.0/';

    const CAMPAIGN_SUMMARY_REPORT_URI = '{account_id}/reports/campaign-summary/dimensions/{dimension}';
}
