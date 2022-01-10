<?php

use ostark\Relax\Relaxants\Queue\HashedJobQueue;

it('swaps queue service if enabled via config', function () {

    // Arrange service
    $settings = new \ostark\Relax\PluginSettings(['hashedQueue' => true]);
    $handler = new \ostark\Relax\Handlers\SearchServiceHandler($settings);
    $handler();

    expect(Craft::$app->getQueue())->toBeInstanceOf(HashedJobQueue::class);
});
