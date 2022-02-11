<?php

declare(strict_types=1);

namespace App\Application\Commands\Handler;

use App\Application\Commands\BlogCreateCommand;
use App\Domain\Model\Blog;
use App\Domain\Repository\BlogRepositoryInterface;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\Repository\Exception\CategoryNotFoundException;
use Ramsey\Uuid\Uuid;

class BlogCreateHandler implements Handler
{
	public function __construct(
		private CategoryRepositoryInterface $categoryRepository,
		private BlogRepositoryInterface $blogRepository
	) {}

	/**
	 * @throws CategoryNotFoundException
	 */
	public function handle(BlogCreateCommand $blogCreateDTO): string
	{
		$blogId = Uuid::uuid4()->toString();
		$category = $this->categoryRepository->get($blogCreateDTO->categoryId);

		$blog = new Blog(
			$blogId,
			$blogCreateDTO->name,
			$blogCreateDTO->alias,
			$blogCreateDTO->userId,
			$blogCreateDTO->author,
			$category
		);
		$this->blogRepository->add($blog);

		return $blogId;
	}
}