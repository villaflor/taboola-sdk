<?php

declare(strict_types=1);

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\TaboolaSDK\Configurations\Images\ImageUploadConfiguration;
use Villaflor\TaboolaSDK\Configurations\Images\MediaLibraryConfiguration;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Endpoints\Images;

beforeEach(function () {
    $this->adapter = Mockery::mock(AdapterInterface::class);
    $this->endpoint = new Images($this->adapter);
    $this->accountId = 'demo-account-001';
});

afterEach(function () {
    Mockery::close();
});

it('can upload image', function () {
    $config = new ImageUploadConfiguration($this->accountId);
    $imageData = ['url' => 'https://example.com/image.jpg'];

    $responseData = json_encode(['id' => 'img-123', 'url' => 'https://example.com/image.jpg']);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->uploadImage($config, $imageData);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->id)->toBe('img-123');
});

it('can get media library taxonomies', function () {
    $responseData = json_encode([
        'results' => [
            ['id' => '1', 'name' => 'Category 1'],
            ['id' => '2', 'name' => 'Category 2'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getMediaLibraryTaxonomies();

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray();
});

it('can get media library images', function () {
    $config = new MediaLibraryConfiguration();

    $responseData = json_encode([
        'results' => [
            ['id' => 'img-1', 'url' => 'https://example.com/1.jpg'],
            ['id' => 'img-2', 'url' => 'https://example.com/2.jpg'],
        ],
        'metadata' => [],
    ]);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getMediaLibraryImages($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray()
        ->and($result->results)->toHaveCount(2);
});

it('can upload to media library', function () {
    $config = new ImageUploadConfiguration($this->accountId);
    $imageData = ['url' => 'https://example.com/image.jpg', 'taxonomy_id' => '5'];

    $responseData = json_encode(['id' => 'img-456', 'url' => 'https://example.com/image.jpg']);
    $response = mockResponse($responseData);

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->uploadToMediaLibrary($config, $imageData);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->id)->toBe('img-456');
});
