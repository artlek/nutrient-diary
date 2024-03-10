<?php

namespace App\Service\ObjectDeleter;

interface IObjectDeleter
{
    public function delete($object): void;
}