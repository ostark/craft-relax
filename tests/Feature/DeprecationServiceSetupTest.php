<?php

use ostark\Relax\Handlers\DeprecationServiceHandler;
use ostark\Relax\PluginSettings;

beforeEach(function () {
    Craft::$app->set('deprecator', new \craft\services\Deprecator());
});


it('mutes depreaction logs if enabled via config', function () {
    // Arrange service
    $settings = new PluginSettings(['muteDeprecations' => true]);
    $handler = new DeprecationServiceHandler($settings);
    $handler();

    // Act: use deprecator
    $deprecator = Craft::$app->getDeprecator();
    $deprecator->log('nope', 'Do not call nope().');

    // Assert
    expect($deprecator->getRequestLogs())->toHaveCount(0);
    expect($deprecator->logTarget)->toEqual(false);
});

it('logs depreactions if not muted via config', function () {
    // Arrange service
    $settings = new PluginSettings(['muteDeprecations' => false]);
    $handler = new DeprecationServiceHandler($settings);
    $handler();

    // Act: use deprecator
    $deprecator = Craft::$app->getDeprecator();
    $deprecator->log('not-cool-anymore', 'Why not cool anymore.');
    $deprecator->log('use-the-new-way', 'How to use the new way.');

    // Assert
    expect($deprecator->getRequestLogs())->toHaveCount(2);
    expect($deprecator->logTarget)->toEqual('db');
});
