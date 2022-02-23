<?php

declare(strict_types=1);

namespace App\Application\Commands\Handler;

use App\Application\Commands\ArticleEditCommand;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\Exception\ArticleNotFoundException;
use App\Infrastructure\Persistence\Doctrine\ArticleRepository;
use App\Infrastructure\Persistence\Flusher;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ArticleEditHandler
{
	public function __construct(
		private ArticleRepository $articleRepository,
		private Flusher $flusher
	) {}

	/**
	 * @throws ArticleNotFoundException
	 */
	public function handle(ArticleEditCommand $command): void
	{
		$article = $this->articleRepository->get(BlogId::generate($command->articleId));
		if ($article->getAuthor()->getId()->getValue() !== $command->authorId) {
			throw new AccessDeniedException('Only owner of article or admin user can able to edit');
		}
		$article->edit($command->title, $command->content);
		$this->flusher->flush();
	}
}