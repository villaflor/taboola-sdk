<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Endpoints;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Exceptions\JsonDecodeException;

final class Dictionary extends AbstractEndpoint
{
    /**
     * Get list of countries.
     *
     * @throws JsonDecodeException
     */
    public function getCountries(): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . URI::DICTIONARY_COUNTRIES_URI);

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Get regions in a country.
     *
     * @throws JsonDecodeException
     */
    public function getRegions(PathConfigurationInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Get cities in a country.
     *
     * @throws JsonDecodeException
     */
    public function getCities(PathConfigurationInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Get postal codes for a country.
     *
     * @throws JsonDecodeException
     */
    public function getPostalCodes(PathConfigurationInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Get list of platforms.
     *
     * @throws JsonDecodeException
     */
    public function getPlatforms(): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . URI::DICTIONARY_PLATFORMS_URI);

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Get list of operating systems.
     *
     * @throws JsonDecodeException
     */
    public function getOperatingSystems(): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . URI::DICTIONARY_OS_URI);

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Get list of browsers.
     *
     * @throws JsonDecodeException
     */
    public function getBrowsers(): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . URI::DICTIONARY_BROWSERS_URI);

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }
}
