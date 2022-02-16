<?php

declare(strict_types=1);

namespace App\Application\Commands\Handler;

use App\Application\Commands\BlogEditCommand;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\BlogRepositoryInterface;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\Repository\Exception\BlogNotFoundException;
use App\Domain\Repository\Exception\CategoryNotFoundException;
use App\Infrastructure\Persistence\Flusher;

class BlogEditHandler implements Handler
{
	public function __construct(
		private BlogRepositoryInterface $blogRepository,
		private CategoryRepositoryInterface $categoryRepository,
		private Flusher $flusher
	) {}

	/**
	 * @throws BlogNotFoundException
	 * @throws CategoryNotFoundException
	 */
	public function handle(BlogEditCommand $blogEditCommand): void
	{
		$blog = $this->blogRepository->get(BlogId::generate($blogEditCommand->blogId));
		$category = $this->categoryRepository->get(BlogId::generate($blogEditCommand->categoryId));
		$blog->edit($blogEditCommand->name, $blogEditCommand->alias, $category);
		$this->flusher->flush();
	}
}