<?php
declare(strict_types=1);

namespace App\Domain\Repository\Exception;

class CategoryNotFoundException extends ModelRecordNotFoundException
{
    public function __construct()
    {
        parent::__construct('Category not found');
    }
}