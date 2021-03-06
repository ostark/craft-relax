<?php

declare(strict_types=1);

namespace ostark\Relax\Handlers;

use Craft;
use ostark\Relax\PluginSettings;
use ostark\Relax\SearchIndex\SearchService;

class SearchServiceHandler
{
    protected PluginSettings $settings;

    public function __construct(PluginSettings $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke(): void
    {
        // No filters defined?
        if (! $filters = $this->settings->searchIndexInsertFilter) {
            return;
        }

        // Overwrite 'search' key in service locator
        Craft::$app->set('search', function () use ($filters) {
            foreach ($filters as $key => $class) {
                if (is_string($class)) {
                    $filters[$key] = Craft::createObject($class);
                }
            }

            return new SearchService(Craft::$app->getDb(), $filters);
        });
    }
}
