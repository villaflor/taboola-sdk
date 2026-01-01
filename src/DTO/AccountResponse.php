<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\DTO;

use stdClass;

final readonly class AccountResponse
{
    public function __construct(
        public stdClass $body,
    ) {
    }

    public static function fromStdClass(stdClass $data): self
    {
        return new self(body: $data);
    }
}
