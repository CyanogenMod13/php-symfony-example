<?php

namespace App\Repository;

use Doctrine\ORM\EntityNotFoundException;

class BlogNotFoundException extends EntityNotFoundException
{
    public function __construct()
    {
        parent::__construct("Blog not found");
    }
}