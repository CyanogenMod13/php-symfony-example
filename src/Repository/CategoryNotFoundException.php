<?php

namespace App\Repository;

use Doctrine\ORM\EntityNotFoundException;

class CategoryNotFoundException extends EntityNotFoundException
{
    public function __construct()
    {
        parent::__construct('Category not found');
    }
}