<?php

namespace App\Service;

class SetObjectCounter
{
    # sets counter to all objects in array
    public function set(array $objects): array
    {
        for ($i = 0; $i < count($objects); $i++) {
            $objects[$i]->setCounter($i+1);
        }
        return $objects;
    }
}