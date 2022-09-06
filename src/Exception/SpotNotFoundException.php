<?php

namespace App\Exception;

use RuntimeException;

class SpotNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('spot not found');
    }
}