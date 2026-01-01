<?php

declare(strict_types=1);

namespace Villaflor\TaboolaSDK\Configurations\Images;

use Villaflor\TaboolaSDK\Configurations\PathConfigurationInterface;
use Villaflor\TaboolaSDK\Definitions\URI;

final readonly class ImageUploadConfiguration implements PathConfigurationInterface
{
    public function __construct(
        private string $accountId
    ) {
    }

    public function getPath(): string
    {
        return strtr(
            URI::IMAGE_UPLOAD_URI,
            ['{account_id}' => $this->accountId]
        );
    }
}
