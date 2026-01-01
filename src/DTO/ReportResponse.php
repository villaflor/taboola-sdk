<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\DTO;

use stdClass;

final readonly class ReportResponse
{
    /**
     * @param array<int, mixed> $results
     */
    public function __construct(
        public string $timezone,
        public array $results,
        public int $recordCount,
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
            timezone: $data->timezone ?? '',
            results: $data->results ?? [],
            recordCount: $data->record_count ?? $data->recordCount ?? 0,
            metadata: $metadata,
        );
    }
}
