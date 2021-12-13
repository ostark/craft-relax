<?php

namespace VendorName\Skeleton\Handlers;

use VendorName\Skeleton\Settings;

/**
 * What the fuck is a handler?
 * Why a dedicated classs?
 * How to test this?
 *
 */
class SkeletonHandler
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
