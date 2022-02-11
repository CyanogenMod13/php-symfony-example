<?php
declare(strict_types=1);

namespace App\Application\Commands;

class BlogEditCommand
{
    public function __construct(
		public string $blogId,
        public string $name,
        public string $alias,
		public string $categoryId
    ) {}
}