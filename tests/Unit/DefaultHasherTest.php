<?php

declare(strict_types=1);

it('creates a hash from a job object with a time formatted suffix', function () {
    $serializer = new \yii\queue\serializers\PhpSerializer();
    $hasher = new \ostark\Relax\Queue\DefaultHasher($serializer);

    $separator = '__';
    $result = $hasher->hash(new DummyJob());
    [$md5, $suffix] = explode($separator, $result, 2);

    // Not more than 64 chars to fit in the db column
    expect(mb_strlen($result))->toBeLessThanOrEqual(64);
    expect(mb_strlen($result))->toBeGreaterThan(40);

    // Expected format: {md5}__{Ymd.His}
    expect($md5)->toHaveLength(32);
    expect($suffix)->toEndWith('00');
});


class DummyJob implements \craft\queue\JobInterface
{
    public int $prop = 1;

    public function getDescription()
    {
        return 'dummy';
    }

    public function execute($queue)
    {
    }
}
