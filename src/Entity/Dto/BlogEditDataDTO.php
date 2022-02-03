<?php
declare(strict_types=1);

namespace App\Entity\Dto;

class BlogEditDataDTO
{
    public function __construct(
        public string $name,
        public string $alias
    )
    {}
}