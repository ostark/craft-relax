<?php

namespace VendorName\Skeleton;

use craft\base\Plugin;
use VendorName\Skeleton\Handlers\SkeletonHandler;
use VendorName\Skeleton\Handlers\SkeletonService;

/**
 * @method SkeletonSettings getSettings()
 */
class SkeletonPlugin extends Plugin
{
    // public $schemaVersion = '1.0.0';
    // public $hasCpSettings = true;
    // public $hasCpSection = true;

    public function init(): void
    {
        parent::init();

        $this->registerSingletons();
        $this->registerEventHandlers();

        // Register the Settings Model in the container, so we can
        // inject it everywhere filled with config data
        $this->set(SkeletonSettings::class, fn () => $this->getSettings());
    }

    private function registerEventHandlers(): void
    {
        Event::on(
            SomeCraftCoreClass::class,
            SomeCraftCoreClass::EVENT_NAME,
            new SkeletonHandler($this->getSettings())
        );

    }

    private function registerSingletons()
    {
        // Instantiate manually
        $this->set(SkeletonService::class, function($app) {
            return new SkeletonService(
                \Craft::$app->getConfig(),
                $this->getSettings(),
            );
        });

    }

    protected function createSettingsModel(): SkeletonSettings
    {
        return new \VendorName\Skeleton\SkeletonSettings();
    }


}
