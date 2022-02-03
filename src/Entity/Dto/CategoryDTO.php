<?php
declare(strict_types=1);

namespace App\Entity\Dto;

class CategoryDTO
{
    public function __construct(
        public string $name
    )
    {}
}