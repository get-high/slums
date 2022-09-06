<?php

namespace App\Exception;

use RuntimeException;

class CategoryNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('category not found');
    }
}