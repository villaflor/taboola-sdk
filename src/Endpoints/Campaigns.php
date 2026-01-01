<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Endpoints;

use stdClass;
use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Exceptions\JsonDecodeException;

final class Campaigns extends AbstractEndpoint
{
    /**
     * Get all campaigns for an account.
     *
     * @param ConfigurationsInterface&PathConfigurationInterface $configurations
     * @throws JsonDecodeException
     */
    public function getAllCampaigns(ConfigurationsInterface $configurations): CollectionResponse
    {
        $response = $this->adapter->get(
            URI::API_URI . $configurations->getPath(),
            $configurations->getArray()
        );

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Get a single campaign by ID.
     *
     * @throws JsonDecodeException
     */
    public function getCampaign(PathConfigurationInterface $configuration): stdClass
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Create a new campaign.
     *
     * @param array<string, mixed> $campaignData
     * @throws JsonDecodeException
     */
    public function createCampaign(PathConfigurationInterface $configuration, array $campaignData): stdClass
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $campaignData]
        );

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Update an existing campaign.
     *
     * @param array<string, mixed> $campaignData
     * @throws JsonDecodeException
     */
    public function updateCampaign(PathConfigurationInterface $configuration, array $campaignData): stdClass
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $campaignData]
        );

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Delete a campaign.
     *
     * @throws JsonDecodeException
     */
    public function deleteCampaign(PathConfigurationInterface $configuration): stdClass
    {
        $response = $this->adapter->delete(URI::API_URI . $configuration->getPath());

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Duplicate an existing campaign.
     *
     * @param array<string, mixed> $duplicateData
     * @throws JsonDecodeException
     */
    public function duplicateCampaign(PathConfigurationInterface $configuration, array $duplicateData = []): stdClass
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $duplicateData]
        );

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Bulk update campaigns.
     *
     * @param array<int, array<string, mixed>> $campaigns
     * @throws JsonDecodeException
     */
    public function bulkUpdateCampaigns(PathConfigurationInterface $configuration, array $campaigns): CollectionResponse
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $campaigns]
        );

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }
}
