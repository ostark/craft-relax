<?php

declare(strict_types=1);

namespace ostark\Relax;

use craft\base\Plugin as BasePlugin;
use craft\services\Plugins;
use ostark\Relax\Handlers\DeprecationServiceHandler;
use ostark\Relax\Handlers\QueueServiceHandler;
use ostark\Relax\Handlers\SearchServiceHandler;
use phpDocumentor\Reflection\Types\Boolean;
use yii\base\Event;

/**
 * @method PluginSettings getSettings()
 */
final class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = false;
    public bool $hasCpSection = false;

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

    /**
     * Is called after the plugin is installed.
     * Copies example config to project's config folder
     */
    protected function afterInstall(): void
    {
        $configSourceFile = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. 'config.example.php';
        $configTargetFile = \Craft::$app->getConfig()->configDir . DIRECTORY_SEPARATOR . 'relax.php';

        if (! file_exists($configTargetFile)) {
            copy($configSourceFile, $configTargetFile);
        }
    }
}
