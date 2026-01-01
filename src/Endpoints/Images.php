<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Endpoints;

use stdClass;
use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Exceptions\JsonDecodeException;

final class Images extends AbstractEndpoint
{
    /**
     * Upload an image to the account.
     *
     * @param array<string, mixed> $imageData
     * @throws JsonDecodeException
     */
    public function uploadImage(PathConfigurationInterface $configuration, array $imageData): stdClass
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $imageData]
        );

        return $this->decodeJsonResponse($response->getBody());
    }

    /**
     * Get media library taxonomies.
     *
     * @throws JsonDecodeException
     */
    public function getMediaLibraryTaxonomies(): CollectionResponse
    {
        $response = $this->adapter->get(URI::API_URI . URI::IMAGE_LIBRARY_TAXONOMIES_URI);

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Get images from media library.
     *
     * @throws JsonDecodeException
     */
    public function getMediaLibraryImages(ConfigurationsInterface $configuration): CollectionResponse
    {
        $response = $this->adapter->get(
            URI::API_URI . URI::IMAGE_LIBRARY_GET_URI,
            $configuration->getArray()
        );

        $data = $this->decodeJsonResponse($response->getBody());

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * Upload an image to media library.
     *
     * @param array<string, mixed> $imageData
     * @throws JsonDecodeException
     */
    public function uploadToMediaLibrary(PathConfigurationInterface $configuration, array $imageData): stdClass
    {
        $response = $this->adapter->post(
            URI::API_URI . $configuration->getPath(),
            ['json' => $imageData]
        );

        return $this->decodeJsonResponse($response->getBody());
    }
}
