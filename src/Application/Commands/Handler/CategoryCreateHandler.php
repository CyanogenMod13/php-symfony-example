<?php

declare(strict_types=1);

namespace App\Application\Commands\Handler;

use App\Application\Commands\CategoryCreateCommand;
use App\Domain\Model\Blog\Category;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\CategoryRepositoryInterface;

class CategoryCreateHandler implements Handler
{
	public function __construct(
		private CategoryRepositoryInterface $categoryRepository
	) {}

	public function handle(CategoryCreateCommand $categoryCreateCommand): BlogId
	{
		$categoryId = BlogId::generate();
		$category = new Category($categoryId, $categoryCreateCommand->name);
		$this->categoryRepository->add($category);
		return $categoryId;
	}
}