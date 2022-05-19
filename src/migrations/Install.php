<?php

declare(strict_types=1);

namespace ostark\Relax\migrations;

use craft\db\Migration;
use craft\db\Table;
use ostark\Relax\Queue\HashedJobQueue;

class Install extends Migration
{
    public function safeUp(): bool
    {
        // Same schema as the `queue` table, but with an additional `job_hash` column
        // to prevent duplicated queue messages
        $this->dropTableIfExists(HashedJobQueue::TABLE);
        $this->createTable(HashedJobQueue::TABLE, [
            'id' => $this->primaryKey(),
            'channel' => $this->string()->notNull()->defaultValue('queue'),
            'job' => $this->binary()->notNull(),
            HashedJobQueue::HASH_COLUMN => $this->string(64)->null()->__toString(),
            'description' => $this->text(),
            'timePushed' => $this->integer()->notNull(),
            'ttr' => $this->integer()->notNull(),
            'delay' => $this->integer()->defaultValue(0)->notNull(),
            'priority' => $this->integer()->unsigned()->notNull()->defaultValue(1024),
            'dateReserved' => $this->dateTime(),
            'timeUpdated' => $this->integer(),
            'progress' => $this->smallInteger()->notNull()->defaultValue(0),
            'progressLabel' => $this->string(),
            'attempt' => $this->integer(),
            'fail' => $this->boolean()->defaultValue(false),
            'dateFailed' => $this->dateTime(),
            'error' => $this->text(),
        ]);

        $this->createIndex('channel_timePushed_idx', HashedJobQueue::TABLE, ['channel', 'fail', 'timeUpdated', 'timePushed']);
        $this->createIndex('channel_delay_idx', HashedJobQueue::TABLE, ['channel', 'fail', 'timeUpdated', 'delay']);
        $this->createIndex(HashedJobQueue::HASH_INDEX, HashedJobQueue::TABLE, [HashedJobQueue::HASH_COLUMN]);

        return true;
    }

    public function safeDown(): bool
    {
        $this->dropTableIfExists(HashedJobQueue::TABLE);

        return true;
    }
}
