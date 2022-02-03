<?php
declare(strict_types=1);

namespace App\Entity\Dto;

class BlogDTO
{
    public function __construct(
        public string $name,
        public string $alias,
        public AuthorDTO $author,
        public CategoryDTO $category
    )
    {}
}