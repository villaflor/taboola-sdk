<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Endpoints;

use Villaflor\Connection\ConfigurationsInterface;
use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;
use Villaflor\TaboolaSDK\DTO\ReportResponse;
use Villaflor\TaboolaSDK\Exceptions\JsonDecodeException;

final class Reporting extends AbstractEndpoint
{
    /**
     * Get campaign summary report.
     *
     * @throws JsonDecodeException
     */
    public function getCampaignSummaryReport(ConfigurationsInterface $configuration): ReportResponse
    {
        return $this->fetchReport($configuration);
    }

    /**
     * Get top campaign content report.
     *
     * @throws JsonDecodeException
     */
    public function getTopCampaignContentReport(ConfigurationsInterface $configuration): ReportResponse
    {
        return $this->fetchReport($configuration);
    }

    /**
     * Get realtime campaign report.
     *
     * @throws JsonDecodeException
     */
    public function getRealtimeCampaignReport(ConfigurationsInterface $configuration): ReportResponse
    {
        return $this->fetchReport($configuration);
    }

    /**
     * Get realtime ads report.
     *
     * @throws JsonDecodeException
     */
    public function getRealtimeAdsReport(ConfigurationsInterface $configuration): ReportResponse
    {
        return $this->fetchReport($configuration);
    }

    /**
     * @param ConfigurationsInterface&PathConfigurationInterface $configuration
     * @throws JsonDecodeException
     */
    private function fetchReport(ConfigurationsInterface $configuration): ReportResponse
    {
        $response = $this->adapter->get(
            URI::API_URI . $configuration->getPath(),
            $configuration->getArray()
        );

        $data = $this->decodeJsonResponse($response->getBody());

        return ReportResponse::fromStdClass($data);
    }
}
