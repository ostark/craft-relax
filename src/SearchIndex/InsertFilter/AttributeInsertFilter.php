<?php

namespace ostark\Relax\SearchIndex\InsertFilter;

use ostark\Relax\SearchIndex\InsertFilter;

class AttributeInsertFilter implements InsertFilter
{

    public array $skippableAttributes = ['slug', 'extension', 'kind'];

    public function skip(array $columns): bool
    {
        return in_array($columns['attribute'], $this->skippableAttributes);
    }
}
