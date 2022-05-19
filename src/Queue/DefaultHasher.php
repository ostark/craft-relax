<?php

declare(strict_types=1);

namespace ostark\Relax\Queue;

use yii\queue\serializers\SerializerInterface;

class DefaultHasher implements Hasher
{
    public int $precisionInMinutes = 10;

    public SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer, int $minutes = 10)
    {
        $this->serializer = $serializer;
        $this->precisionInMinutes = $minutes;
    }

    /**
     * @param \yii\queue\JobInterface|string $job
     *
     * @return string
     */
    public function hash($job): string
    {
        $hash = md5($this->serializer->serialize($job));

        return sprintf("%s__%s", $hash, $this->timeSuffix());
    }

    private function timeSuffix(string $format = 'Ymd.His'): string
    {
        $precision = $this->precisionInMinutes * 60;
        $rounded = (int) ceil(time() / $precision) * $precision;

        return date($format, $rounded);
    }
}
