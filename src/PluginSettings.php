<?php

declare(strict_types=1);

namespace ostark\Relax;

use craft\base\Model;
use ostark\Relax\SearchIndex\InsertFilter\UselessAttributes;
use ostark\Relax\SearchIndex\InsertFilter\UselessKeywords;

class PluginSettings extends Model
{
    public bool $hashedQueue = true;

    public bool $muteDeprecations = true;

    /**
     * @var class-string[]
     */
    public array $searchIndexInsertFilter = [
        UselessAttributes::class,
        UselessKeywords::class,
    ];
}
