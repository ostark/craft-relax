<?php

namespace ostark\Relax\Relaxants\SearchIndex\InsertFilter;

use ostark\Relax\Relaxants\SearchIndex\InsertFilter;

class KeywordInsertFilter implements InsertFilter
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
