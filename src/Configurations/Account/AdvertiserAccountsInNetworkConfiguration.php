<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\Account;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class AdvertiserAccountsInNetworkConfiguration implements PathConfigurationInterface
{
    public function __construct(
        private string $accountId
    ) {
    }

    public function getPath(): string
    {
        return strtr(
            URI::ACCOUNT_ADVERTISER_ACCOUNTS_IN_NETWORK_URI,
            ['{account_id}' => $this->accountId]
        );
    }
}
