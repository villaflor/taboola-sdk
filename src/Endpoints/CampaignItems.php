<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Endpoints;

use stdClass;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Exceptions\JsonDecodeException;

final class CampaignItems extends AbstractEndpoint
{
    /**
     * Get all items for a campaign.
     *
     * @throws JsonDecodeException
     */
    public function getAllItems(PathConfigurationInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Get a single campaign item.
     *
     * @throws JsonDecodeException
     */
    public function getItem(PathConfigurationInterface $configuration): stdClass
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Create a new campaign item.
     *
     * @param array<string, mixed> $itemData
     * @throws JsonDecodeException
     */
    public function createItem(PathConfigurationInterface $configuration, array $itemData): stdClass
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $itemData]
        );

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Update a campaign item.
     *
     * @param array<string, mixed> $itemData
     * @throws JsonDecodeException
     */
    public function updateItem(PathConfigurationInterface $configuration, array $itemData): stdClass
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $itemData]
        );

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Delete a campaign item.
     *
     * @throws JsonDecodeException
     */
    public function deleteItem(PathConfigurationInterface $configuration): stdClass
    {
        $response = $this->adapter->delete(URI::API_URI . $configuration->getPath());

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Bulk create items for a campaign.
     *
     * @param array<int, array<string, mixed>> $items
     * @throws JsonDecodeException
     */
    public function bulkCreateItems(PathConfigurationInterface $configuration, array $items): CollectionResponse
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $items]
        );

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Bulk update items across campaigns.
     *
     * @param array<int, array<string, mixed>> $items
     * @throws JsonDecodeException
     */
    public function bulkUpdateItems(PathConfigurationInterface $configuration, array $items): CollectionResponse
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $items]
        );

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Bulk delete items.
     *
     * @param array<int, string> $itemIds
     * @throws JsonDecodeException
     */
    public function bulkDeleteItems(PathConfigurationInterface $configuration, array $itemIds): stdClass
    {
        $response = $this->adapter->delete(
            URI::API_URI . $configuration->getPath(),
            ['json' => $itemIds]
        );

        return $this->decodeJsonResponse($response->getBody());
    }
}
