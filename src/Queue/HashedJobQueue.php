<?php

namespace ostark\Relax\Queue;

use craft\db\Query;
use craft\helpers\Db;
use craft\queue\Queue;
use craft\queue\QueueInterface;

class HashedJobQueue extends Queue implements QueueInterface
{
    public const HASH_COLUMN = 'job_hash';
    public const HASH_INDEX = 'idx_hash';

    public ?DefaultHasher $hasher;
    private static array $cache = [];

    public function init()
    {
        parent::init();

        $this->hasher = new DefaultHasher($this->serializer);
    }

    /**
     * @inheritdoc
     */
    public function push($job)
    {
        $hash = $this->hasher->hash($job);

        // Avoid duplicates within this cycle
        if (in_array($hash, static::$cache)) {
            return null;
        }

        array_push(static::$cache, $hash);

        parent::push($job);
    }

    /**
     * @inheritdoc
     */
    protected function pushMessage($message, $ttr, $delay, $priority)
    {
        $hash = $this->hasher->hash($message);
        $found = (new Query())
            ->from($this->tableName)
            ->where([self::HASH_COLUMN => $hash])
            ->count('*', $this->db);

        if ($found) {
            return null;
        }

        $data = [
            'job' => $message,
            'description' => $this->_jobDescription,
            'timePushed' => time(),
            'ttr' => $ttr,
            'delay' => $delay,
            'priority' => $priority ?: 1024,
            self::HASH_COLUMN => $hash
        ];

        Db::insert($this->tableName, $data, false, $this->db);
        return $this->db->getLastInsertID($this->tableName);
    }


}
