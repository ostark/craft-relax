<?php

declare(strict_types=1);

namespace ostark\Relax\SearchIndex\InsertFilter;

use ostark\Relax\SearchIndex\InsertFilter;

class UselessAttributes implements InsertFilter
{
    public array $skippableAttributes = ['slug', 'extension', 'kind'];

    public function skip(array $columns): bool
    {
        return in_array($columns['attribute'], $this->skippableAttributes);
    }
}
