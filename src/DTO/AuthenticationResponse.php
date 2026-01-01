<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\DTO;

use stdClass;

final readonly class AuthenticationResponse
{
    public function __construct(
        public string $accessToken,
        public string $tokenType,
        public int $expiresIn,
    ) {
    }

    public static function fromStdClass(stdClass $data): self
    {
        return new self(
            accessToken: $data->access_token ?? '',
            tokenType: $data->token_type ?? 'Bearer',
            expiresIn: $data->expires_in ?? 0,
        );
    }
}
