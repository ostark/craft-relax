<?php

declare(strict_types=1);

namespace ostark\Relax\Handlers;

use Craft;
use craft\queue\Queue;
use ostark\Relax\PluginSettings;
use ostark\Relax\Queue\DefaultHasher;
use ostark\Relax\Queue\HashedJobQueue;

class QueueServiceHandler
{
    protected PluginSettings $settings;

    public function __construct(PluginSettings $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke(): void
    {
        // Disabled in settings?
        if (! $this->settings->hashedQueue) {
            return;
        }

        // Do nothing if it's not the default queue (database)
        if (get_class(Craft::$app->getQueue()) !== Queue::class) {
            return;
        }

        // Initialize HashedJobQueue
        $serializer = Craft::$app->getQueue()->serializer;
        $hasher = new DefaultHasher($serializer);
        $queue = new HashedJobQueue($hasher);

        // Overwrite 'queue' key in service locator
        Craft::$app->set('queue', $queue);

        // Overwrite 'queue' property of queue\Command
        if (isset(Craft::$app->controllerMap['queue']['queue'])) {
            Craft::$app->controllerMap['queue']['queue'] = $queue;
        }

        // Extrawurst for feed-me
        if ($feedMe = Craft::$app->getPlugins()->getPlugin('feed-me')) {
            $feedMe->queue = $queue;
        };
    }
}
