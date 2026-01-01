<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses()->in(__DIR__);

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Load a fixture file and return its contents as an array
 *
 * @param string $path Path to fixture file relative to tests/Fixtures directory (e.g., 'Campaigns/all_campaigns.json')
 * @return array<string, mixed>
 */
function loadFixture(string $path): array
{
    $fixturePath = __DIR__ . '/Fixtures/' . $path;

    if (! file_exists($fixturePath)) {
        throw new RuntimeException("Fixture file not found: {$fixturePath}");
    }

    $contents = file_get_contents($fixturePath);
    $decoded = json_decode($contents, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException("Invalid JSON in fixture file {$path}: " . json_last_error_msg());
    }

    return $decoded;
}

/**
 * Create a mock PSR-7 response from fixture data
 *
 * @param string $fixturePath Path to fixture file (e.g., 'Campaigns/all_campaigns.json')
 * @return Psr\Http\Message\ResponseInterface
 */
function mockResponseFromFixture(string $fixturePath): Psr\Http\Message\ResponseInterface
{
    $data = loadFixture($fixturePath);

    return mockResponse($data);
}

/**
 * Create a mock PSR-7 response from array or string data
 *
 * @param string|array<string, mixed> $data
 * @return Psr\Http\Message\ResponseInterface
 */
function mockResponse(string|array $data): Psr\Http\Message\ResponseInterface
{
    $responseData = is_array($data) ? json_encode($data) : $data;

    $stream = Mockery::mock(Psr\Http\Message\StreamInterface::class);
    $stream->shouldReceive('__toString')->andReturn($responseData);

    $response = Mockery::mock(Psr\Http\Message\ResponseInterface::class);
    $response->shouldReceive('getBody')->andReturn($stream);

    return $response;
}
