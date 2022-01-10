<?php


it('swaps search service and command if default filters are configured', function () {
    // Arrange service
    $settings = new \ostark\Relax\PluginSettings();
    $handler = new \ostark\Relax\Handlers\SearchServiceHandler($settings);
    $handler();

    // Act
    try {
        $element = new \craft\elements\GlobalSet();
        $service = Craft::$app->getSearch();
        $service->indexElementAttributes($element);
    } catch (\Exception $e) {
        // It will try to execute sql query
    }

    // Assert
    expect($service)->toBeInstanceOf(\ostark\Relax\Relaxants\SearchIndex\SearchService::class);
    expect(Craft::$app->getDb()->commandClass)->toEqual(\ostark\Relax\Relaxants\SearchIndex\SearchIndexCommand::class);

});

it('keeps the default service if no filters are configured', function () {
    // Arrange service
    $settings = new \ostark\Relax\PluginSettings(['searchIndexInsertFilter' => []]);
    $handler = new \ostark\Relax\Handlers\SearchServiceHandler($settings);
    $handler();

    // Act
    $service = Craft::$app->getSearch();

    // Assert
    expect($service)->toBeInstanceOf(\craft\services\Search::class);
});

