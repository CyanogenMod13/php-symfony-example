<?php

declare(strict_types=1);

namespace App\Application\Commands\Handler;

use App\Application\Commands\ArticlePublishCommand;
use App\Domain\Model\Blog\Article;
use App\Domain\Model\Blog\Event\ArticlePublishedEvent;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\Exception\AuthorNotFoundException;
use App\Infrastructure\Persistence\Doctrine\ArticleRepository;
use App\Infrastructure\Persistence\Doctrine\AuthorRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ArticlePublisherHandler
{
	public function __construct(
		private ArticleRepository $articleRepository,
		private AuthorRepository $authorRepository,
		private EventDispatcherInterface $dispatcher
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

		$this->dispatcher->dispatch(new ArticlePublishedEvent($article), ArticlePublishedEvent::NAME);
		return $article;
	}
}