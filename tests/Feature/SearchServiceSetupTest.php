<?php

declare(strict_types=1);

use craft\elements\GlobalSet;
use craft\services\Search;
use ostark\Relax\Handlers\SearchServiceHandler;
use ostark\Relax\PluginSettings;
use ostark\Relax\SearchIndex\SearchIndexCommand;
use ostark\Relax\SearchIndex\SearchService;

it('swaps search service and command if default filters are configured', function () {
    // Arrange service
    $settings = new PluginSettings();
    $handler = new SearchServiceHandler($settings);
    $handler();

    // Act
    try {
        $element = new GlobalSet();
        $service = Craft::$app->getSearch();
        $service->indexElementAttributes($element);
    } catch (\Exception $e) {
        // It will try to execute sql query
    }

    // Assert
    expect($service)->toBeInstanceOf(SearchService::class);
    expect(Craft::$app->getDb()->commandClass)->toEqual(SearchIndexCommand::class);
});

it('keeps the default service if no filters are configured', function () {
    // Arrange service
    $settings = new PluginSettings(['searchIndexInsertFilter' => []]);
    $handler = new SearchServiceHandler($settings);
    $handler();

    // Act
    $service = Craft::$app->getSearch();

    // Assert
    expect($service)->toBeInstanceOf(Search::class);
});
