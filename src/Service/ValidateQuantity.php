<?php

namespace App\Service;

class ValidateQuantity
{
    public function validate($quantity) : bool
    {
        if(is_float($quantity) AND $quantity > 0){
            return true;
        }
        else{
            return false;
        }
    }
}