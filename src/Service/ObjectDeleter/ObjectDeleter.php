<?php

namespace App\Service\ObjectDeleter;

use App\Service\ObjectDeleter\IObjectDeleter;

class ObjectDeleter
{
    private IObjectDeleter $object;

    public function __construct(IObjectDeleter $object)
    {
        $this->object = $object;
    }

    public function delete($obj): void
    {
        $this->object->delete($obj);
    }
}