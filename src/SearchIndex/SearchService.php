<?php

namespace ostark\Relax\SearchIndex;

use craft\base\ElementInterface;
use craft\db\Command;
use craft\db\Connection;
use craft\services\Search;

class SearchService extends Search
{
    protected Connection $connection;

    /**
     * @var \ostark\Relax\SearchIndex\InsertFilter[]
     */
    protected array $filters = [];

    /**
     * @param \craft\db\Connection $connection
     * @param \ostark\Relax\SearchIndex\InsertFilter[] $filters
     */
    public function __construct(Connection $connection, array $filters = [])
    {
        parent::__construct();
        $this->filters = $filters;
        $this->connection = $connection;
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
     * @param string                                   $class
     * @param \ostark\Relax\SearchIndex\InsertFilter[] $filters
     */
    private function setDbCommand(string $class, $filters = []): void
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
