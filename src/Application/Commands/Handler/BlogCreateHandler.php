<?php

declare(strict_types=1);

namespace App\Application\Commands\Handler;

use App\Application\Commands\BlogCreateCommand;
use App\Domain\Model\Blog\Blog;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\BlogRepositoryInterface;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\Repository\Exception\CategoryNotFoundException;

class BlogCreateHandler implements Handler
{
	public function __construct(
		private CategoryRepositoryInterface $categoryRepository,
		private BlogRepositoryInterface $blogRepository
	) {}

	/**
	 * @throws CategoryNotFoundException
	 */
	public function handle(BlogCreateCommand $blogCreateDTO): BlogId
	{
		$blogId = BlogId::generate();
		$category = $this->categoryRepository->get(BlogId::generate($blogCreateDTO->categoryId));

		$blog = new Blog(
			$blogId,
			$blogCreateDTO->name,
			$blogCreateDTO->alias,
			BlogId::generate($blogCreateDTO->userId),
			$blogCreateDTO->author,
			$category
		);
		$this->blogRepository->add($blog);

		return $blogId;
	}
}