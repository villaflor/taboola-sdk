<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Endpoints;

use stdClass;
use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Exceptions\JsonDecodeException;

final class Targeting extends AbstractEndpoint
{
    /**
     * Get available publishers for targeting.
     *
     * @param ConfigurationsInterface&PathConfigurationInterface $configuration
     * @throws JsonDecodeException
     */
    public function getPublishers(ConfigurationsInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(
            URI::API_URI . $configuration->getPath(),
            $configuration->getArray()
        );

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Get blocked publishers list.
     *
     * @throws JsonDecodeException
     */
    public function getBlockedPublishers(PathConfigurationInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Update blocked publishers list.
     *
     * @param array<string, mixed> $blockedPublishers
     * @throws JsonDecodeException
     */
    public function updateBlockedPublishers(PathConfigurationInterface $configuration, array $blockedPublishers): stdClass
    {
        $response = $this->adapter->put(
            URI::API_URI . $configuration->getPath(),
            ['json' => $blockedPublishers]
        );

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Get postal code targeting for a campaign.
     *
     * @throws JsonDecodeException
     */
    public function getPostalCodeTargeting(PathConfigurationInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Update postal code targeting for a campaign.
     *
     * @param array<string, mixed> $postalCodes
     * @throws JsonDecodeException
     */
    public function updatePostalCodeTargeting(PathConfigurationInterface $configuration, array $postalCodes): stdClass
    {
        $response = $this->adapter->put(
            URI::API_URI . $configuration->getPath(),
            ['json' => $postalCodes]
        );

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Get marketplace audience targeting for a campaign.
     *
     * @throws JsonDecodeException
     */
    public function getMarketplaceAudienceTargeting(PathConfigurationInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Update marketplace audience targeting for a campaign.
     *
     * @param array<string, mixed> $audiences
     * @throws JsonDecodeException
     */
    public function updateMarketplaceAudienceTargeting(PathConfigurationInterface $configuration, array $audiences): stdClass
    {
        $response = $this->adapter->put(
            URI::API_URI . $configuration->getPath(),
            ['json' => $audiences]
        );

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Get contextual targeting for a campaign.
     *
     * @throws JsonDecodeException
     */
    public function getContextualTargeting(PathConfigurationInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Update contextual targeting for a campaign.
     *
     * @param array<string, mixed> $contextual
     * @throws JsonDecodeException
     */
    public function updateContextualTargeting(PathConfigurationInterface $configuration, array $contextual): stdClass
    {
        $response = $this->adapter->put(
            URI::API_URI . $configuration->getPath(),
            ['json' => $contextual]
        );

        return $this->decodeJsonResponse($response->getBody());
    }
}
