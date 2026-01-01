<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\Account;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class AllowedAccountsConfiguration implements PathConfigurationInterface
{
    public function getPath(): string
    {
        return URI::ACCOUNT_ALLOWED_ACCOUNTS_URI;
    }
}
