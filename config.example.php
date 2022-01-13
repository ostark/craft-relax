<?php
/**
 * Relax Plugin Configuration
 *
 * You can see a list of the available settings in
 * vendor/ostark/craft-relax/src/Settings.php.
 *
 * @see \ostark\Relax\PluginSettings
 */

use craft\helpers\App;
use ostark\Relax\SearchIndex\InsertFilter\UselessAttributes;
use ostark\Relax\SearchIndex\InsertFilter\UselessKeywords;

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
     * (bool) false - the default queue behaviour of Craft
     */
    // 'hashedQueue' => false,


    /**
     * Search index inserts
     *
     * By default these filters prevent bloated indexes
     * @see ostark\Relax\SearchIndex\InsertFilter\UselessAttributes
     * @see ostark\Relax\SearchIndex\InsertFilter\UselessKeywords
     *
     * Define your own filters to adjust the opinionated behaviour of the plugin
     */
    // 'searchIndexInsertFilter' => [],
];
