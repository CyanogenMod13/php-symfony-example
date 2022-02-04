<?php
declare(strict_types=1);

namespace App\Service;

use App\Controller\Json\Data\CategoryCreateData;
use App\Entity\Blog;
use App\Entity\Category;
use App\Repository\CategoryNotFoundException;
use App\Repository\CategoryRepository;
use Ramsey\Uuid\Uuid;

class CategoryService
{
	public function __construct(
		public CategoryRepository $categoryRepository
	) {}

	/**
	 * @throws CategoryNotFoundException
	 */
	public function getCategoryData(string $categoryId): Category
	{
		return $this->categoryRepository->get($categoryId);
	}

	/**
	 * @return Category[]
	 */
	public function getAllCategory(): array
	{
		return $this->categoryRepository->getAll();
	}

	/**
	 * @return Blog[]
	 * @throws CategoryNotFoundException
	 */
	public function getBlogByCategory(string $categoryId): array
	{
		return $this->categoryRepository->get($categoryId)->getBlogs();
	}

	public function addCategory(CategoryCreateData $categoryData): string
	{
		$categoryId = Uuid::uuid4()->toString();
		$category = new Category($categoryId, $categoryData->name);
		$this->categoryRepository->add($category);
		return $categoryId;
	}
}