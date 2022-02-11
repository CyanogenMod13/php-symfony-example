<?php
declare(strict_types=1);

namespace App\Domain\Repository\Exception;

class BlogNotFoundException extends ModelRecordNotFoundException
{
    public function __construct()
    {
        parent::__construct("Blog not found");
    }
}