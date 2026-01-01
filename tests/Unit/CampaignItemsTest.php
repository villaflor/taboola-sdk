<?php

declare(strict_types=1);

use Villaflor\Connection\Adapter\AdapterInterface;
use Villaflor\TaboolaSDK\Configurations\CampaignItems\AllCampaignItemsConfiguration;
use Villaflor\TaboolaSDK\Configurations\CampaignItems\SingleCampaignItemConfiguration;
use Villaflor\TaboolaSDK\DTO\CollectionResponse;
use Villaflor\TaboolaSDK\Endpoints\CampaignItems;

beforeEach(function () {
    $this->adapter = Mockery::mock(AdapterInterface::class);
    $this->endpoint = new CampaignItems($this->adapter);
    $this->accountId = 'demo-account-001';
    $this->campaignId = '1234';
});

afterEach(function () {
    Mockery::close();
});

it('can get all items', function () {
    $config = new AllCampaignItemsConfiguration($this->accountId, $this->campaignId);

    $response = mockResponseFromFixture('CampaignItems/all_items.json');

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getAllItems($config);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray()
        ->and($result->results)->toHaveCount(3);

    expect($result->results[0])->toBeInstanceOf(stdClass::class)
        ->and($result->results[0]->id)->toBe('1')
        ->and($result->results[0]->title)->toBe('Demo Article 1');
});

it('can get single item', function () {
    $config = new SingleCampaignItemConfiguration($this->accountId, $this->campaignId, '1');

    $response = mockResponseFromFixture('CampaignItems/single_item.json');

    $this->adapter
        ->shouldReceive('get')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->getItem($config);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->id)->toBe('1')
        ->and($result->title)->toBe('Demo Article 1')
        ->and($result->cpc)->toBe(0.25);
});

it('can create item', function () {
    $config = new SingleCampaignItemConfiguration($this->accountId, $this->campaignId, '');
    $itemData = ['title' => 'New Item', 'url' => 'https://example.com'];

    $response = mockResponseFromFixture('CampaignItems/created_item.json');

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->createItem($config, $itemData);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->id)->toBe('item-new-789')
        ->and($result->title)->toBe('New Campaign Item');
});

it('can update item', function () {
    $config = new SingleCampaignItemConfiguration($this->accountId, $this->campaignId, '1');
    $itemData = ['title' => 'Updated Item'];

    $response = mockResponseFromFixture('CampaignItems/updated_item.json');

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->updateItem($config, $itemData);

    expect($result)->toBeInstanceOf(stdClass::class)
        ->and($result->id)->toBe('1')
        ->and($result->title)->toBe('Updated Demo Article');
});

it('can delete item', function () {
    $config = new SingleCampaignItemConfiguration($this->accountId, $this->campaignId, '1');

    $response = mockResponseFromFixture('CampaignItems/deleted_item.json');

    $this->adapter
        ->shouldReceive('delete')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->deleteItem($config);

    expect($result)->toBeInstanceOf(stdClass::class);
});

it('can bulk create items', function () {
    $config = new AllCampaignItemsConfiguration($this->accountId, $this->campaignId);
    $items = [
        ['title' => 'Item 1', 'url' => 'https://example.com/1'],
        ['title' => 'Item 2', 'url' => 'https://example.com/2'],
    ];

    $response = mockResponseFromFixture('CampaignItems/bulk_created_items.json');

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->bulkCreateItems($config, $items);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray()
        ->and($result->results)->toHaveCount(2);

    expect($result->results[0])->toBeInstanceOf(stdClass::class)
        ->and($result->results[0]->id)->toBe('101');
});

it('can bulk update items', function () {
    $config = new AllCampaignItemsConfiguration($this->accountId, $this->campaignId);
    $items = [
        ['id' => '1', 'cpc' => 0.45],
        ['id' => '2', 'cpc' => 0.50],
    ];

    $response = mockResponseFromFixture('CampaignItems/bulk_updated_items.json');

    $this->adapter
        ->shouldReceive('post')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->bulkUpdateItems($config, $items);

    expect($result)->toBeInstanceOf(CollectionResponse::class)
        ->and($result->results)->toBeArray()
        ->and($result->results)->toHaveCount(2);

    expect($result->results[0])->toBeInstanceOf(stdClass::class)
        ->and($result->results[0]->cpc)->toBe(0.45);
});

it('can bulk delete items', function () {
    $config = new AllCampaignItemsConfiguration($this->accountId, $this->campaignId);
    $itemIds = ['1', '2', '3'];

    $response = mockResponse(['success' => true]);

    $this->adapter
        ->shouldReceive('delete')
        ->once()
        ->andReturn($response);

    $result = $this->endpoint->bulkDeleteItems($config, $itemIds);

    expect($result)->toBeInstanceOf(stdClass::class);
});
