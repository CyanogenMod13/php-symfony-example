<?php

declare(strict_types=1);

namespace App\Application\Commands\Handler;

use App\Application\Commands\ArticlePublishCommand;
use App\Domain\Model\Article;
use App\Domain\Model\Type\BlogId;
use App\Domain\Repository\BlogRepositoryInterface;
use App\Domain\Repository\Exception\AuthorNotFoundException;
use App\Infrastructure\Persistence\Doctrine\ArticleRepository;
use App\Infrastructure\Persistence\Doctrine\AuthorRepository;
use Ramsey\Uuid\Uuid;

class ArticlePublisherHandler
{
	public function __construct(
		private ArticleRepository $articleRepository,
		private AuthorRepository $authorRepository,
	) {}

	/**
	 * @throws AuthorNotFoundException
	 */
	public function handle(ArticlePublishCommand $articleCreateData): Article
	{
		$author = $this->authorRepository->get(BlogId::generate($articleCreateData->authorId));
		$article = new Article(
			BlogId::generate(),
			$articleCreateData->title,
			$articleCreateData->content,
			$author
		);
		$this->articleRepository->add($article);
		return $article;
	}
}