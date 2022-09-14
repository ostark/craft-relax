<?php

declare(strict_types=1);

namespace ostark\Relax\Queue;

use craft\db\Query;
use craft\helpers\Db;
use craft\queue\JobInterface as CraftJob;
use craft\queue\Queue;
use craft\queue\QueueInterface;
use yii\base\InvalidConfigException;
use function RectorPrefix20220501\Symfony\Component\DependencyInjection\Loader\Configurator\param;

class HashedJobQueue extends Queue implements QueueInterface
{
    public const HASH_COLUMN = 'job_hash';
    public const HASH_INDEX = 'hash_idx';
    public const TABLE = 'queue_hashed';
    public static array $cache = [];
    public Hasher $hasher;

    private ?string $jobDescription;

    public ?string $channel = 'queue';

    public function __construct(Hasher $hasher, $config = [])
    {
        parent::__construct($config);
        $this->hasher = $hasher;
        $this->tableName = self::TABLE;
    }

    /**
     * @param mixed|\yii\queue\JobInterface $job
     *
     * @return string|null
     */
    public function push($job): ?string
    {
        $hash = $this->hasher->hash($job);
        $this->jobDescription = ($job instanceof CraftJob) ? $job->getDescription() : null;

        // Avoid duplicates within this execution cycle
        if (in_array($hash, static::$cache)) {
            return null;
        }

        array_push(static::$cache, $hash);

        return parent::push($job);
    }

    /**
     * @param string $message
     * @param int    $ttr
     * @param int    $delay
     * @param mixed  $priority
     *
     * @return string
     * @throws \yii\db\Exception
     */
    protected function pushMessage($message, $ttr, $delay, $priority): string
    {
        $hash = $this->hasher->hash($message);
        $found = (new Query())
            ->from($this->tableName)
            ->where([self::HASH_COLUMN => $hash])
            ->count('*', $this->db);

        if ($found) {
            return '1';
        }

        $data = [
            'job' => $message,
            'description' => $this->jobDescription,
            'timePushed' => time(),
            'ttr' => $ttr,
            'delay' => $delay,
            'priority' => $priority ?: 1024,
            self::HASH_COLUMN => $hash,
        ];

        Db::insert($this->tableName, $data, $this->db);

        return $this->db->getLastInsertID($this->tableName);
    }
}
