<?php

declare(strict_types=1);

use Villaflor\TaboolaSDK\Configurations\Dictionary\CountryResourceConfiguration;
use Villaflor\TaboolaSDK\Definitions\URI;

it('generates correct path for regions', function () {
    $config = new CountryResourceConfiguration('US', 'regions');

    expect($config->getPath())->toBe(str_replace('{country_code}', 'US', URI::DICTIONARY_REGIONS_URI));
});

it('generates correct path for cities', function () {
    $config = new CountryResourceConfiguration('CA', 'cities');

    expect($config->getPath())->toBe(str_replace('{country_code}', 'CA', URI::DICTIONARY_CITIES_URI));
});

it('generates correct path for postal codes', function () {
    $config = new CountryResourceConfiguration('GB', 'postal-codes');

    expect($config->getPath())->toBe(str_replace('{country_code}', 'GB', URI::DICTIONARY_POSTAL_CODES_URI));
});

it('defaults to regions for unknown resource type', function () {
    $config = new CountryResourceConfiguration('FR', 'unknown');

    expect($config->getPath())->toBe(str_replace('{country_code}', 'FR', URI::DICTIONARY_REGIONS_URI));
});

it('defaults to regions when no resource type specified', function () {
    $config = new CountryResourceConfiguration('DE');

    expect($config->getPath())->toBe(str_replace('{country_code}', 'DE', URI::DICTIONARY_REGIONS_URI));
});
