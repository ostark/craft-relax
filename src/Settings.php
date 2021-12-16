<?php

namespace ostark\Relax;

use craft\base\Model;
use ostark\Relax\Relaxants\SearchIndex\InsertFilter\AttributeInsertFilter;
use ostark\Relax\Relaxants\SearchIndex\InsertFilter\KeywordInsertFilter;

class Settings extends Model
{
    public bool $muteDeprecations = true;
    public array $searchIndexInsertFilter = [
        AttributeInsertFilter::class,
        KeywordInsertFilter::class
    ];


}
