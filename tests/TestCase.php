<?php

namespace Villaflor\TaboolaSDK\Tests;

use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class TestCase extends BaseTestCase
{
    protected $accountID = 'demo-account-001';

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * Returns a PSR7 Stream for a given fixture.
     *
     * @param string $fixture The fixture to create the stream for.
     * @return Psr7\Stream
     */
    protected function getPsr7StreamForFixture(string $fixture): Psr7\Stream
    {
        $path = sprintf('%s/Fixtures/%s', __DIR__, $fixture);

        $this->assertFileExists($path);

        $stream = Utils::streamFor(file_get_contents($path));

        $this->assertInstanceOf(Psr7\Stream::class, $stream);

        return $stream;
    }

    /**
     * Returns a PSR7 Response (JSON) for a given fixture.
     *
     * @param string $fixture    The fixture to create the response for.
     * @param integer $statusCode A HTTP Status Code for the response.
     * @return Psr7\Response
     */
    protected function getPsr7JsonResponseForFixture(string $fixture, int $statusCode = 200): Psr7\Response
    {
        $stream = $this->getPsr7StreamForFixture($fixture);

        $this->assertNotNull(json_decode($stream));
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        return new Psr7\Response($statusCode, ['Content-Type' => 'application/json'], $stream);
    }
}
