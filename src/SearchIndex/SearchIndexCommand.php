<?php

declare(strict_types=1);

namespace ostark\Relax\SearchIndex;

use craft\db\Command;
use craft\db\Table;

class SearchIndexCommand extends Command
{
    /**
     * @var \ostark\Relax\SearchIndex\InsertFilter[]
     */
    public array $filters = [];

    public function insert($table, $columns): Command
    {
        if ($table === Table::SEARCHINDEX) {
            if ($this->applyFilters($columns)) {
                return $this;
            }
        }

        return parent::insert($table, $columns);
    }

    protected function applyFilters(array $columns): bool
    {
        foreach ($this->filters as $filter) {
            if ($filter->skip($columns)) {
                return true;
            }
        }

        return false;
    }
}
