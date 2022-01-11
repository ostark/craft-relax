<?php

namespace ostark\Relax\SearchIndex;

use craft\db\Command;
use craft\db\Table;

class SearchIndexCommand extends Command
{
    /**
     * @var \ostark\Relax\SearchIndex\InsertFilter[]
     */
    public array $filters = [];

    public function insert($table, $columns, $includeAuditColumns = true)
    {
        if ($table === Table::SEARCHINDEX) {
            if ($this->applyFilters($columns)) {
                return $this;
            }
        }

        return parent::insert($table, $columns, $includeAuditColumns);
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

