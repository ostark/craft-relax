<?php

namespace ostark\Relax;

use craft\base\Model;
use ostark\Relax\Relaxants\SearchIndex\InsertFilter\UselessAttributes;
use ostark\Relax\Relaxants\SearchIndex\InsertFilter\UselessKeywords;

class PluginSettings extends Model
{
    public bool $hashedQueue = true;
    public bool $muteDeprecations = true;
    public array $searchIndexInsertFilter = [
        UselessAttributes::class,
        UselessKeywords::class
    ];


}
