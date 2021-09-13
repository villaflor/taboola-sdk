<?php

namespace Villaflor\TaboolaSDK;

use Villaflor\Connection\Adapter\Guzzle;
use Villaflor\Connection\Auth\AuthInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

class TaboolaClient extends Guzzle
{
    public function __construct(AuthInterface $auth, string $baseURI = null)
    {
        parent::__construct($auth, $baseURI ?? URI::BASE_URI);
    }
}
