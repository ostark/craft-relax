<?php

declare(strict_types=1);

namespace ostark\Relax\Queue;

interface Hasher
{
    /**
     * @param \yii\queue\JobInterface|string $job
     *
     * @return string
     */
    public function hash($job): string;
}
