<?php
/**
 * Relax Plugin Configuration
 *
 * You can see all the available settings and defaults in
 * vendor/ostark/craft-relax/src/PluginSettings.php.
 *
 * @see \ostark\Relax\PluginSettings
 */

use craft\helpers\App;

return [

    /**
     * Deprecation logging
     *
     * App::env('ENVIRONMENT') !== 'dev' means:
     * no deprecation logging in non-dev environments
     * (bool) false - the default behaviour of Craft: log to deprecations table
     */
    'muteDeprecations' => App::env('ENVIRONMENT') !== 'dev',


    /**
     * Queue
     *
     * (bool) true means: Use the queue the plugin provides
     * (bool) false means: Use the default queue behaviour of Craft
     */
    // 'hashedQueue' => false,


    /**
     * Search index inserts
     *
     * By default these filters are applied
     * @see ostark\Relax\SearchIndex\InsertFilter\UselessAttributes
     * @see ostark\Relax\SearchIndex\InsertFilter\UselessKeywords
     *
     * Define your own filters to adjust the opinionated filters of the plugin.
     * An empty array disables all filters.
     */
    // 'searchIndexInsertFilter' => [],
];
