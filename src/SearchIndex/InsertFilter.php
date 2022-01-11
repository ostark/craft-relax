<?php

namespace ostark\Relax\SearchIndex;

interface InsertFilter
{
    /**
     * @param array $columns
     * Example:
     * [
     *   'attribute' => 'slug',
     *   'keywords' => 'group of keywords'
     * ]
     *
     * @return bool
     */
    public function skip(array $columns): bool;
}
