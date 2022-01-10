<?php

namespace ostark\Relax\Handlers;

use Craft;
use craft\queue\Queue;
use ostark\Relax\Relaxants\Queue\HashedJobQueue;
use ostark\Relax\PluginSettings;

class QueueServiceHandler
{
    protected PluginSettings $settings;

    public function __construct(PluginSettings $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke()
    {
        // Disabled in settings?
        if (!$this->settings->hashedQueue) {
            return;
        }

        // Do nothing if it's not the default queue (database)
        if (get_class(Craft::$app->getQueue()) !== Queue::class) {
            return;
        }

        // Overwrite 'queue' key in service locator
        Craft::$app->set('queue', HashedJobQueue::class);
    }
}
