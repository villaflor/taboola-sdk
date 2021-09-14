<p align="center">

  <a href="https://github.com/villaflor/taboola-sdk/actions/workflows/test.yml">
    <img src="https://img.shields.io/github/workflow/status/villaflor/taboola-sdk/Test">
  </a>
  <a href="https://github.com/villaflor/taboola-sdk/blob/main/LICENSE">
    <img src="https://img.shields.io/github/license/villaflor/taboola-sdk.svg?style=flat">
  </a>
  <a href="https://packagist.org/packages/villaflor/taboola-sdk">
    <img src="https://img.shields.io/packagist/php-v/villaflor/taboola-sdk">
  </a>
  <a href="https://packagist.org/packages/villaflor/taboola-sdk">
    <img src="https://img.shields.io/packagist/v/villaflor/taboola-sdk">
  </a>
</p>

# Connecting to the Taboola API has never been easier.

---

**This package contains the open source PHP SDK, which allows your PHP application to connect to the Taboola Platform.**

## Requirement

- [x] Client ID\
A *client_id* must be included in every request to the Authorization Server. The Authorization Server will then know who is making the request.

- [x] Client Secret\
A *client_secret* is also required in order to use the Client Credentials flow.

- [x] Account ID\
You'll need your Advertiser (or Publisher) *account_id* before you can use the Backstage API. This is the account that you will use to execute API activities, such as campaign creation.

> *Note: Request your client_id and client_secret from your Taboola Account Manager. Your account_id, as well as your client id and client secret, are supplied to you throughout the API onboarding process.* 

## Installation
In the root application directory, run this command.

    composer require villaflor/taboola-sdk

## Usage

    use Villaflor\Connection\Auth\APIToken;
    use Villaflor\Connection\Auth\None;
    use Villaflor\TaboolaSDK\Configurations\Account\AccountDetailsConfiguration;
    use Villaflor\TaboolaSDK\Configurations\Account\AdvertiserAccountsInNetworkConfiguration;
    use Villaflor\TaboolaSDK\Configurations\Account\AllowedAccountsConfiguration;
    use Villaflor\TaboolaSDK\Configurations\AuthenticationConfiguration;
    use Villaflor\TaboolaSDK\Configurations\Campaigns\AllCampaignsConfiguration;
    use Villaflor\TaboolaSDK\Configurations\Reporting\CampaignSummaryConfiguration;
    use Villaflor\TaboolaSDK\Configurations\Reporting\TopCampaignContentConfiguration;
    use Villaflor\TaboolaSDK\Definitions\AllCampaignsFilterDefinition;
    use Villaflor\TaboolaSDK\Definitions\CampaignSummaryDimensionDefinition;
    use Villaflor\TaboolaSDK\Definitions\CampaignSummaryFilterDefinition;
    use Villaflor\TaboolaSDK\Definitions\TopCampaignContentDimensionDefinition;
    use Villaflor\TaboolaSDK\Definitions\TopCampaignContentFilterDefinition;
    use Villaflor\TaboolaSDK\Endpoints\Account;
    use Villaflor\TaboolaSDK\Endpoints\Authentication;
    use Villaflor\TaboolaSDK\Endpoints\Campaigns;
    use Villaflor\TaboolaSDK\Endpoints\Reporting;
    use Villaflor\TaboolaSDK\TaboolaClient;
    
    class MyClass
    {
        public function __inovke()
        {
            $clientID = '1234abcd123abcd';
            $clientSecret = '1234567890qwertyui';
            $accountId = 'demo-account-001';
        
            $accessToken = $this->getAccessToken(
                new Authentication(new TaboolaClient(new None())),
                new AuthenticationConfiguration($clientID, $clientSecret)
            );
        
            var_dump($accessToken);
    
            $auth = new APIToken($accessToken);
            $taboolaClient = new TaboolaClient($auth);
    
            $accountDetails = $this->getAccountDetails(
                new Account($taboolaClient),
                new AccountDetailsConfiguration()
            );
        
            var_dump($accountDetails);
    
            $advertiserAccountsInNetwork = $this->getAdvertiserAccountsInNetwork(
                new Account($taboolaClient),
                new AdvertiserAccountsInNetworkConfiguration($accountId)
            );
    
            var_dump($advertiserAccountsInNetwork);
    
            $allowedAccounts = $this->getAllowedAccounts(
                new Account($taboolaClient),
                new AllowedAccountsConfiguration(),
            );
        
            var_dump($allowedAccounts);
    
            $allCampaigns = $this->getAllCampaigns(
                new Campaigns($taboolaClient),
                new AllCampaignsConfiguration($accountId, [
                    AllCampaignsFilterDefinition::FETCH_LEVEL => AllCampaignsFilterDefinition::FETCH_LEVEL_RECENT_AND_PAUSED_OPTIONS
                ])
            );
        
            var_dump($allCampaigns);
    
            $campaignSummaryReport = $this->getCampaignSummaryReport(
                new Reporting($taboolaClient),
                new CampaignSummaryConfiguration(
                    $accountId,
                    CampaignSummaryDimensionDefinition::CAMPAIGN_DAY_BREAKDOWN,
                    [
                        CampaignSummaryFilterDefinition::START_DATE => '2021-08-01',
                        CampaignSummaryFilterDefinition::END_DATE => '2021-08-01',
                    ]
                )
            );
        
            var_dump($campaignSummaryReport);
    
            $topCampaignContentReport = $this->getTopCampaignContentReport(
                new Reporting($taboolaClient),
                new TopCampaignContentConfiguration(
                    $accountId,
                    TopCampaignContentDimensionDefinition::ITEM_BREAKDOWN,
                    [
                        TopCampaignContentFilterDefinition::START_DATE => '2021-08-01',
                        TopCampaignContentFilterDefinition::END_DATE => '2021-08-01',
                    ]
                )
            );
    
            var_dump($topCampaignContentReport);
        }
        
        private function getAccessToken($service, $config)
        {
            $result = $service->getAccessToken($config);
    
            return $result->body->access_token;
        }
        
        private function getAccountDetails($service, $config)
        {
            return $service->getAccountDetails($config);
        }
        
        private function getAdvertiserAccountsInNetwork($service, $config)
        {
            return $service->getAdvertiserAccountsInNetwork($config);
        }
    
        private function getAllowedAccounts($service, $config)
        {
            return $service->getAllowedAccounts($config);
        }
    
        private function getAllCampaigns($service, $config)
        {
            return $service->getAllCampaigns($config);
        }
    
        private function getCampaignSummaryReport($service, $config)
        {
            return $service->getCampaignSummaryReport($config);
        }
    
        private function getTopCampaignContentReport($service, $config)
        {
            return $service->getTopCampaignContentReport($config);
        }
    }