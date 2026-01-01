<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\DTO;

use stdClass;

final readonly class CollectionResponse
{
    /**
     * @param array<int, mixed> $results
     */
    public function __construct(
        public array $results,
        public stdClass $metadata,
    ) {
    }

    public static function fromStdClass(stdClass $data): self
    {
        $metadata = $data->metadata ?? new stdClass();

        // Convert array to stdClass if needed
        if (is_array($metadata)) {
            $metadata = (object) $metadata;
        }

        return new self(
            results: $data->results ?? [],
            metadata: $metadata,
        );
    }
}
