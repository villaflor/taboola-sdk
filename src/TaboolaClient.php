<?php

namespace Villaflor\TaboolaSDK;

use Villaflor\Connection\Adapter\Guzzle;
use Villaflor\Connection\Auth\AuthInterface;

class TaboolaClient extends Guzzle
{
    public function __construct(AuthInterface $auth, string $baseURI = null)
    {
        parent::__construct($auth, $baseURI ?? Variables::BASE_URI);
    }
}
