<?php

namespace App\Application\Commands;

use App\Domain\Model\AuthorInfo;

class BlogCreateCommand
{
    public function __construct(
        public string $userId,
        public string $name,
        public string $alias,
        public string $categoryId,
        public AuthorInfo $author
    ) {}
}