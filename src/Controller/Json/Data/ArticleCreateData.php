<?php

declare(strict_types=1);

namespace App\Controller\Json\Data;

class ArticleCreateData
{
	public function __construct(
		public string $authorId,
		public string $title,
		public string $content
	) {}
}