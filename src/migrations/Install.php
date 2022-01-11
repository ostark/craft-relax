<?php

namespace ostark\Relax\migrations;

use craft\db\Migration;
use craft\db\Table;
use ostark\Relax\Queue\HashedJobQueue;



class Install extends Migration
{

    public function safeUp(): bool
    {
        $this->addColumn(Table::QUEUE, HashedJobQueue::HASH_COLUMN, $this->uid());
        $this->createIndex(HashedJobQueue::HASH_INDEX, Table::QUEUE, [HashedJobQueue::HASH_COLUMN]);

        return true;
    }

    public function safeDown(): bool
    {
        $this->dropIndex(HashedJobQueue::HASH_INDEX, Table::QUEUE);
        $this->dropColumn(Table::QUEUE, HashedJobQueue::HASH_COLUMN);

        return true;
    }

}
