<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Endpoints;

use stdClass;
use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Exceptions\JsonDecodeException;

final class Audiences extends AbstractEndpoint
{
    /**
     * Get all custom audiences for an account.
     *
     * @throws JsonDecodeException
     */
    public function getCustomAudiences(PathConfigurationInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Create a custom audience.
     *
     * @param array<string, mixed> $audienceData
     * @throws JsonDecodeException
     */
    public function createCustomAudience(PathConfigurationInterface $configuration, array $audienceData): stdClass
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $audienceData]
        );

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Get marketplace audiences.
     *
     * @throws JsonDecodeException
     */
    public function getMarketplaceAudiences(ConfigurationsInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(
            URI::API_URI . URI::AUDIENCE_MARKETPLACE_URI,
            $configuration->getArray()
        );

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Get lookalike audiences for an account.
     *
     * @throws JsonDecodeException
     */
    public function getLookalikeAudiences(PathConfigurationInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Create a lookalike audience.
     *
     * @param array<string, mixed> $audienceData
     * @throws JsonDecodeException
     */
    public function createLookalikeAudience(PathConfigurationInterface $configuration, array $audienceData): stdClass
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $audienceData]
        );

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Get contextual segments.
     *
     * @throws JsonDecodeException
     */
    public function getContextualSegments(): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . URI::AUDIENCE_CONTEXTUAL_SEGMENTS_URI);

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }
}
