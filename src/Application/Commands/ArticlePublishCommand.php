<?php

declare(strict_types=1);

namespace App\Application\Commands;

class ArticlePublishCommand
{
	public function __construct(
		public string $authorId,
		public string $title,
		public string $content,
		public string $blogId
	) {}
}