<?php

namespace App\Service\ObjectNameChecker;

interface IObjectNameChecker
{
    public function check($object): bool;
}