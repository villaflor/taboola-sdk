<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK;

use Villaflor\Connection\Adapter\Curl;
use Villaflor\Connection\Auth\AuthInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

class TaboolaClient extends Curl
{
    public function __construct(AuthInterface $auth, ?string $baseURI = null)
    {
        parent::__construct($auth, $baseURI ?? URI::BASE_URI);
    }
}
