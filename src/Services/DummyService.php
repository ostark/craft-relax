<?php

namespace ostark\Relax\Services;

use craft\config\GeneralConfig;
use craft\services\Config;
use ostark\Relax\RelaxPlugin;
use ostark\Relax\Settings;
use yii\base\Application;

/**
 * What the fuck is a service?
 * Why should we inject dependencies?
 * How to test this?
 */
class DummyService
{

    protected GeneralConfig $config;

    protected Settings $settings;

    public function __construct(GeneralConfig $generalConfig, Settings $settings)
    {
        $this->config = $generalConfig;
        $this->settings = $settings;
    }

    public function doSomeThing(): bool
    {
        if ($this->config->devMode === true) {
           // Craft devMode only
        }

        if ($this->settings->bar === 'someValue') {
            // RelaxPlugin setting bar is someValue
        }

        return false;
    }
}
