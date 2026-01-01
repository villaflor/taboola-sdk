<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Endpoints;

use stdClass;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Exceptions\JsonDecodeException;

final class ConversionTracking extends AbstractEndpoint
{
    /**
     * Get all conversion rules for an account.
     *
     * @throws JsonDecodeException
     */
    public function getAllConversionRules(PathConfigurationInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Get a single conversion rule.
     *
     * @throws JsonDecodeException
     */
    public function getConversionRule(PathConfigurationInterface $configuration): stdClass
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Create a conversion rule.
     *
     * @param array<string, mixed> $conversionData
     * @throws JsonDecodeException
     */
    public function createConversionRule(PathConfigurationInterface $configuration, array $conversionData): stdClass
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $conversionData]
        );

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Update a conversion rule.
     *
     * @param array<string, mixed> $conversionData
     * @throws JsonDecodeException
     */
    public function updateConversionRule(PathConfigurationInterface $configuration, array $conversionData): stdClass
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $conversionData]
        );

        return $this->decodeJsonResponse($response->getBody());
    }
}
