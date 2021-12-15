<?php

namespace ostark\Relax;

use craft\base\Plugin as BasePlugin;
use ostark\Relax\Handlers\FooHandler;
use ostark\Relax\SearchIndex\Filters\AttributeFilter;
use ostark\Relax\SearchIndex\Filters\KeywordFilter;
use ostark\Relax\SearchIndex\SearchService;
use ostark\Relax\Services\DummyService;

/**
 * @method Settings getSettings()
 */
class Plugin extends BasePlugin
{
    // public $schemaVersion = '1.0.0';
    // public $hasCpSettings = true;
    // public $hasCpSection = true;

    public function init(): void
    {
        parent::init();

        $this->registerSingletons();
        $this->registerEventHandlers();

        $this->configureSearchService();
        $this->configureDepreactionService();

    }


    private function registerEventHandlers(): void
    {
        Event::on(
            SomeCraftCoreClass::class,
            SomeCraftCoreClass::EVENT_NAME,
            new FooHandler($this->getSettings())
        );

    }

    private function registerSingletons()
    {
        // Register the Settings Model in the container, so we can
        // inject it everywhere filled with config data
        \Craft::$container->setSingleton(Settings::class, fn () => $this->getSettings());

        // Instantiate manually
        \Craft::$container->set(DummyService::class, function() {
            return new DummyService(\Craft::$app->getConfig()->general, $this->getSettings());
        });

    }

    private function configureSearchService(): void
    {
        \Craft::$app->set('search', function () {
            $filters = [AttributeFilter::class, KeywordFilter::class];
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



    protected function createSettingsModel(): Settings
    {
        return new Settings();
    }


}
