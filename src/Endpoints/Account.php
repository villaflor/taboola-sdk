<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Endpoints;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;
use Villaflor\TaboolaSDK\DTO\AccountResponse;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Exceptions\JsonDecodeException;

final class Account extends AbstractEndpoint
{
    /**
     * @throws JsonDecodeException
     */
    public function getAccountDetails(PathConfigurationInterface $configuration): AccountResponse
    {
        $data = $this->fetchAccount($configuration);

        return AccountResponse::fromStdClass($data);
    }

    /**
     * @throws JsonDecodeException
     */
    public function getAdvertiserAccountsInNetwork(PathConfigurationInterface $configuration): CollectionResponse
    {
        $data = $this->fetchAccount($configuration);

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * @throws JsonDecodeException
     */
    public function getAllowedAccounts(PathConfigurationInterface $configuration): CollectionResponse
    {
        $data = $this->fetchAccount($configuration);

        return CollectionResponse::fromStdClass($data);
    }

    /**
     * @throws JsonDecodeException
     */
    private function fetchAccount(PathConfigurationInterface $configuration): \stdClass
    {
        $response = $this->adapter->get(URI::API_URI . $configuration->getPath());

        return $this->decodeJsonResponse($response->getBody());
    }
}
