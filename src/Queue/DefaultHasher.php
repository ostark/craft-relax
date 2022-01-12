<?php

namespace ostark\Relax\Queue;

use yii\queue\serializers\SerializerInterface;

class DefaultHasher implements Hasher
{
    public int $seconds = 600;

    public SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer, int $seconds = 600)
    {
        $this->serializer = $serializer;
        $this->seconds = $seconds;
    }

    /**
     * @param \yii\queue\JobInterface|string $job
     *
     * @return string
     */
    public function hash($job): string
    {
        $hash = md5($this->serializer->serialize($job));

        return sprintf("%s.%d", $hash, $this->roundedTimestamp());
    }

    private function roundedTimestamp(): int
    {
        return (int) round(time() / $this->seconds) * $this->seconds;
    }
}
