<?php

use ostark\Relax\Handlers\QueueServiceHandler;
use ostark\Relax\PluginSettings;
use ostark\Relax\Queue\HashedJobQueue;

it('swaps queue service if enabled via config', function () {
    // Arrange service
    Craft::$app->set('queue', craft\queue\Queue::class);
    $settings = new PluginSettings(['hashedQueue' => true]);
    $handler = new QueueServiceHandler($settings);
    $handler();

    // Assert
    expect(Craft::$app->getQueue())->toBeInstanceOf(HashedJobQueue::class);
});

it('keeps queue service if not using database queue', function () {
    // Arrange service
    Craft::$app->set('queue', new class () extends \yii\queue\sync\Queue {});
    $settings = new PluginSettings(['hashedQueue' => true]);
    $handler = new QueueServiceHandler($settings);
    $handler();

    // Assert
    expect(Craft::$app->getQueue())->not()->toBeInstanceOf(HashedJobQueue::class);
});
