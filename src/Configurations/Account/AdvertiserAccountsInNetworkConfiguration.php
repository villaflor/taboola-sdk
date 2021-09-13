<?php

namespace Villaflor\TaboolaSDK\Configurations\Account;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

class AdvertiserAccountsInNetworkConfiguration implements PathConfigurationInterface
{
    private $pathConfig;

    public function __construct(string $accountID)
    {
        $this->pathConfig = [
            '{account_id}' => $accountID,
        ];
    }

    public function getPath(): string
    {
        return strtr(URI::ACCOUNT_ADVERTISER_ACCOUNTS_IN_NETWORK_URI, $this->pathConfig);
    }
}
