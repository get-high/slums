<?php

namespace App\Exception;

use RuntimeException;

class SpotAlreadyExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('spot already exists');
    }
}