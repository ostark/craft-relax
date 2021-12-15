<?php

namespace ostark\Relax\SearchIndex;

interface Filter
{
    /**
     * @param array $columns
     *    {
     *      'attribute': 'slug',
     *      'keywords': 'chain of keywords'
     *    }
     * @return bool
     */
    public function skip(array $columns): bool;
}
