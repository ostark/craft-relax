<?php

namespace ostark\Relax\Relaxants\Queue;

use yii\queue\JobInterface;
use yii\queue\serializers\SerializerInterface;

class DefaultHasher
{
    public int $seconds = 600;

    public SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer, int $seconds = 600)
    {
        $this->serializer = $serializer;
        $this->seconds = $seconds;
    }

    public function hash($job): string
    {
        $hash = md5($this->serializer->serialize($job));

        return sprintf("%s.%d", $hash, $this->roundedTimestamp());

    }

    private function roundedTimestamp(): int
    {
        return round(time()/$this->seconds)*$this->seconds;
    }
}
