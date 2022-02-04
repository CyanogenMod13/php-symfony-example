<?php

namespace App\Controller\Json\Data;

use App\Entity\AuthorInfo;

class BlogCreateData
{
    public function __construct(
        public string $userId,
        public string $name,
        public string $alias,
        public string $categoryId,
        public AuthorInfo $author
    ) {}
}