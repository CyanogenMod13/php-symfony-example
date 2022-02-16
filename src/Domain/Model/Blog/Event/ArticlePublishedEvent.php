<?php

declare(strict_types=1);

namespace App\Domain\Model\Blog\Event;

use App\Domain\Model\Blog\Article;
use Symfony\Contracts\EventDispatcher\Event;

class ArticlePublishedEvent extends Event
{
	public const NAME = 'article.published';

	public function __construct(
		private Article $article
	) {}

	public function getArticle(): Article
	{
		return $this->article;
	}
}