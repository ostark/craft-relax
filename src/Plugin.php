<?php

namespace ostark\Relax;

use craft\base\Plugin as BasePlugin;
use craft\services\Plugins;
use ostark\Relax\Handlers\DeprecationServiceHandler;
use ostark\Relax\Handlers\QueueServiceHandler;
use ostark\Relax\Handlers\SearchServiceHandler;
use yii\base\Event;


/**
 * @method PluginSettings getSettings()
 */
final class Plugin extends BasePlugin
{
    public $schemaVersion = '1.0.0';
    public $hasCpSettings = false;
    public $hasCpSection = false;


    public function init(): void
    {
        parent::init();

        Event::on(Plugins::class, Plugins::EVENT_AFTER_LOAD_PLUGINS, new SearchServiceHandler($this->getSettings()));
        Event::on(Plugins::class, Plugins::EVENT_AFTER_LOAD_PLUGINS, new DeprecationServiceHandler($this->getSettings()));
        Event::on(Plugins::class, Plugins::EVENT_AFTER_LOAD_PLUGINS, new QueueServiceHandler($this->getSettings()));
    }


    protected function createSettingsModel(): PluginSettings
    {
        return new PluginSettings();
    }
}
