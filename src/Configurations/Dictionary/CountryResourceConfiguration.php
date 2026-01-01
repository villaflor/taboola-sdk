<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\Dictionary;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class CountryResourceConfiguration implements PathConfigurationInterface
{
    public function __construct(
        private string $countryCode,
        private string $resourceType = 'regions'
    ) {
    }

    public function getPath(): string
    {
        return match ($this->resourceType) {
            'regions' => strtr(
                URI::DICTIONARY_REGIONS_URI,
                ['{country_code}' => $this->countryCode]
            ),
            'cities' => strtr(
                URI::DICTIONARY_CITIES_URI,
                ['{country_code}' => $this->countryCode]
            ),
            'postal-codes' => strtr(
                URI::DICTIONARY_POSTAL_CODES_URI,
                ['{country_code}' => $this->countryCode]
            ),
            default => strtr(
                URI::DICTIONARY_REGIONS_URI,
                ['{country_code}' => $this->countryCode]
            ),
        };
    }
}
