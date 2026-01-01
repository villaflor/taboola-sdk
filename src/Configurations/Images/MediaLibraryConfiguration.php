<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\Images;

use Villaflor\Connection\ConfigurationsInterface;

final readonly class MediaLibraryConfiguration implements ConfigurationsInterface
{
    /**
     * @param array<string, mixed> $filters
     */
    public function __construct(
        private array $filters = []
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function getArray(): array
    {
        return $this->filters;
    }
}
