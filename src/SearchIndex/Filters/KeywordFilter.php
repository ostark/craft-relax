<?php

namespace ostark\Relax\SearchIndex\Filters;

use ostark\Relax\SearchIndex\Filter;

class KeywordFilter implements Filter
{

    public function skip(array $columns): bool
    {
        $keywords = preg_replace('/\s+/', '', $columns['keywords']);

        if (strlen($keywords) <= 3) {
            return true;
        }

        if (is_numeric($keywords)) {
            return true;
        }

        return false;

    }
}
