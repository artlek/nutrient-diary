<?php

namespace App\Service\ObjectAdder;

use App\Service\ObjectAdder\IObjectAdder;

class ObjectAdder
{
    private IObjectAdder $object;

    public function __construct(IObjectAdder $object)
    {
        $this->object = $object;
    }

    public function add($obj): bool
    {
        return $this->object->add($obj);
    }
}