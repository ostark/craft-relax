<?php

namespace ostark\Relax\Handlers;

use Craft;
use ostark\Relax\PluginSettings;
use yii\base\Event;

class DeprecationServiceHandler
{
    protected PluginSettings $settings;

    public function __construct(PluginSettings $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke(): void
    {
        // Disabled in config?
        if (!$this->settings->muteDeprecations) {
            return;
        }

        // Change behaviour of Deprecator
        Craft::$app->getDeprecator()->logTarget = false;
    }
}
