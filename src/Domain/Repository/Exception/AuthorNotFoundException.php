<?php
declare(strict_types=1);

namespace App\Domain\Repository\Exception;

class AuthorNotFoundException extends ModelRecordNotFoundException
{
    public function __construct()
    {
        parent::__construct("Author not found");
    }
}