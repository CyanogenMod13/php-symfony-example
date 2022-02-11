<?php

declare(strict_types=1);

namespace App\Application\Commands\Handler;

use App\Application\Commands\CategoryCreateCommand;
use App\Domain\Model\Category;
use App\Domain\Repository\CategoryRepositoryInterface;
use Ramsey\Uuid\Uuid;

class CategoryCreateHandler implements Handler
{
	public function __construct(
		private CategoryRepositoryInterface $categoryRepository
	) {}

	public function handle(CategoryCreateCommand $categoryCreateCommand): string
	{
		$categoryId = Uuid::uuid4()->toString();
		$category = new Category($categoryId, $categoryCreateCommand->name);
		$this->categoryRepository->add($category);
		return $categoryId;
	}
}