<?php

namespace App\Service\ObjectNameChecker;

use App\Service\ObjectNameChecker\IObjectNameChecker;

class ObjectNameChecker
{
    private IObjectNameChecker $object;

    public function __construct(IObjectNameChecker $object)
    {
        $this->object = $object;
    }

    public function check($obj): bool
    {
        return $this->object->check($obj);
    }
}