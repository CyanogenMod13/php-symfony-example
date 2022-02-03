<?php

namespace App\Entity\Dto;

class BlogCreateDTO
{
    public function __construct(
        public string $userId,
        public string $name,
        public string $alias,
        public string $categoryId,
        public AuthorDTO $author
    )
    {}
}