<?php

namespace ostark\Relax\Queue;

interface Hasher
{
    /**
     * @param \yii\queue\JobInterface|string $job
     *
     * @return string
     */
    function hash($job): string;
}
