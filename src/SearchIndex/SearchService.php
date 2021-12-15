<?php

namespace ostark\Relax\SearchIndex;

use craft\base\ElementInterface;
use craft\db\Command;
use craft\db\Connection;
use craft\elements\db\ElementQuery;
use craft\services\Search;
use ostark\Relax\SearchIndex\Filters\AttributeFilter;
use ostark\Relax\SearchIndex\Filters\KeywordFilter;

class SearchService extends Search
{
    protected Connection $connection;

    /**
     * @var \ostark\Relax\SearchIndex\Filter[]
     */
    protected array $filters = [];


    public function __construct(Connection $connection, $filters = [])
    {
        $this->connection = $connection;
        $this->filters = $filters;
    }


    public function indexElementAttributes(ElementInterface $element, array $fieldHandles = null): bool
    {
        // Overwrite the Command used in the actual call
        $this->setDbCommand(SearchIndexCommand::class, $this->filters);

        // Execute the actual call
        $success = parent::indexElementAttributes($element, $fieldHandles);

        // Revert to the default
        $this->setDbCommand(Command::class);

        return $success;
    }

    /**
     * @param string $class
     * @param \ostark\Relax\SearchIndex\Filter[]  $filters
     */
    private function setDbCommand(string $class, $filters = [])
    {
        $config = [
            'class' => $class,
        ];

        if ($filters) {
            $config['filters'] = $filters;
        }

        $this->connection->commandClass =  $class;
        $this->connection->commandMap['pgsql'] = $config;
        $this->connection->commandMap['mysqli'] =  $config;
        $this->connection->commandMap['mysql'] =  $config;
    }


}
