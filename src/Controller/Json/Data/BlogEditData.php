<?php
declare(strict_types=1);

namespace App\Controller\Json\Data;

class BlogEditData
{
    public function __construct(
        public string $name,
        public string $alias,
		public string $categoryId
    ) {}
}