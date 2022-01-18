<?php

it('creates a hash from a job object with a time formatted suffix', function () {
    $serializer = new \yii\queue\serializers\PhpSerializer();
    $hasher = new \ostark\Relax\Queue\DefaultHasher($serializer);

    $separator = '__';
    $result = $hasher->hash(new DummyJob());
    [$md5, $suffix] = explode($separator, $result, 2);

    expect(mb_strlen($result))->toBeLessThanOrEqual(64);
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
