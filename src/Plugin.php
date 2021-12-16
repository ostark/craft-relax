<?php

namespace ostark\Relax;

use craft\base\Plugin as BasePlugin;
use craft\queue\Queue;
use ostark\Relax\Handlers\FooHandler;
use ostark\Relax\SearchIndex\SearchService;
use yii\base\Event;

/**
 * @method Settings getSettings()
 */
final class Plugin extends BasePlugin
{
    // public $schemaVersion = '1.0.0';
    // public $hasCpSettings = true;
    // public $hasCpSection = true;

    public function init(): void
    {
        parent::init();

        // Register the Settings Model in the container, so we can
        // inject it everywhere filled with config data
        \Craft::$container->setSingleton(Settings::class, fn() => $this->getSettings());

        $this->registerEventHandlers();

        $this->configureSearchService();
        $this->configureDepreactionService();
        $this->configureQueueService();

    }

    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }




    private function configureSearchService(): void
    {
        $filters = $this->getSettings()->searchIndexInsertFilter;

        foreach ($filters as $key => $class) {
            if (is_string($class)) {
                $filters[$key] = \Craft::createObject($class);
            }
        }

        \Craft::$app->set('search', function () use ($filters) {
            return new SearchService(\Craft::$app->getDb(), $filters);
        });
    }

    private function configureDepreactionService(): void
    {
        if (
            $this->getSettings()->muteDeprecations === true &&
            \Craft::$app->getConfig()->general->devMode === false
        ) {
            \Craft::$app->getDeprecator()->logTarget = false;
        }

    }

    private function configureQueueService(): void
    {
        if (get_class(\Craft::$app->getQueue()) !== Queue::class) {
            return;
        }

        \Craft::$app->set('queue', function () {
            return new SearchService(\Craft::$app->getDb(), $filters);
        });

    }



}
