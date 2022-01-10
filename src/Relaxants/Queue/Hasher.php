<?php

namespace ostark\Relax\Relaxants\Queue;

interface Hasher
{
    function hash($job): string;
}
