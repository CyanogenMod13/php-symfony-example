<?php

namespace App\Repository;

use Doctrine\ORM\EntityNotFoundException;

class AuthorNotFoundException extends EntityNotFoundException
{
    public function __construct()
    {
        parent::__construct("Author not found");
    }
}