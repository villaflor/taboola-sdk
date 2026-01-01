<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected string $accountId = 'demo-account-001';
    protected string $clientId = 'test-client-id';
    protected string $clientSecret = 'test-client-secret';
}
