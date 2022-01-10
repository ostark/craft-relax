<?php

namespace ostark\Relax\Relaxants\SearchIndex\InsertFilter;

use ostark\Relax\Relaxants\SearchIndex\InsertFilter;

class UselessKeywords implements InsertFilter
{
    public function skip(array $columns): bool
    {
        $keywords = preg_replace('/\s+/', '', $columns['keywords']);

        // Don't index very short keywords
        if (strlen($keywords) <= 3) {
            return true;
        }

        // Don't index numbers
        if (is_numeric($keywords)) {
            return true;
        }

        return false;
    }
}
