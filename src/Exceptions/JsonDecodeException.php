<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Exceptions;

class JsonDecodeException extends TaboolaException
{
    public static function fromError(string $json, int $errorCode, string $errorMessage): self
    {
        return new self(
            sprintf(
                'Failed to decode JSON: %s. Error: %s',
                $errorMessage,
                $json
            ),
            $errorCode
        );
    }
}
