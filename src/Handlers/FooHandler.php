<?php

namespace ostark\Relax\Handlers;

use ostark\Relax\Settings;


class FooHandler
{
    protected Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }
}
