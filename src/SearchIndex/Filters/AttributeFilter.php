<?php

namespace ostark\Relax\SearchIndex\Filters;

use ostark\Relax\SearchIndex\Filter;

class AttributeFilter implements Filter
{

    public array $skippableAttributes = ['slug', 'extension', 'kind'];

    public function skip(array $columns): bool
    {
        return in_array($columns['attribute'], $this->skippableAttributes);
    }
}
