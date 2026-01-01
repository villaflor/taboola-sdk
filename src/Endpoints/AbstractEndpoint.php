<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Endpoints;

use stdClass;
use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\Connection\APIInterface;
use Villaflor\TaboolaSDK\Exceptions\JsonDecodeException;

abstract class AbstractEndpoint implements APIInterface
{
    public function __construct(
        protected readonly AdapterInterface $adapter
    ) {
    }

    /**
     * @param mixed $json
     * @throws JsonDecodeException
     */
    protected function decodeJsonResponse(mixed $json): stdClass
    {
        // Convert StreamInterface to string if needed
        $jsonString = is_string($json) ? $json : (string) $json;

        $decoded = json_decode($jsonString);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonDecodeException::fromError(
                $jsonString,
                json_last_error(),
                json_last_error_msg()
            );
        }

        return $decoded instanceof stdClass ? $decoded : new stdClass();
    }
}
