<?php

namespace App\Service\ObjectAdder;

interface IObjectAdder
{
    public function add($object): bool;
}