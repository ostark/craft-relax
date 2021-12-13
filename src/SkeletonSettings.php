<?php

namespace VendorName\Skeleton;

use craft\base\Model;

class SkeletonSettings extends Model
{
    public $foo = 'defaultFooValue';
    public $bar = 'defaultBarValue';

    public function rules()
    {
        return [
            [['foo', 'bar'], 'required'],
            // ...
        ];
    }
}
