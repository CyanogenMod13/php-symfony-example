<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Category;
use App\Entity\Dto\BlogDTO;
use App\Entity\Dto\CategoryDTO;
use App\Repository\CategoryNotFoundException;
use App\Repository\CategoryRepository;
use Ramsey\Uuid\Uuid;

class CategoryService
{
	public function __construct(
		public CategoryRepository $categoryRepository
	)
	{}

	/**
	 * @param string $categoryId
	 * @return CategoryDTO
	 * @throws CategoryNotFoundException
	 */
	public function getCategoryData(string $categoryId): CategoryDTO
	{
		return CategoryDTO::toDto($this->categoryRepository->get($categoryId));
	}

	/**
	 * @return CategoryDTO[]
	 */
	public function getAllCategory(): array
	{
		$categoryDTOs = [];
		$categories = $this->categoryRepository->getAll();
		foreach ($categories as $category) {
			$categoryDTOs[] = CategoryDTO::toDto($category);
		}
		return $categoryDTOs;
	}

	/**
	 * @param string $categoryId
	 * @return BlogDTO[]
	 * @throws CategoryNotFoundException
	 */
	public function getBlogByCategory(string $categoryId): array
	{
		$blogDTOs = [];
		$category = $this->categoryRepository->get($categoryId);
		foreach ($category->getBlogs() as $blog) {
			$blogDTOs[] = BlogDTO::toDto($blog);
		}
		return $blogDTOs;
	}

	/**
	 * @param CategoryDTO $categoryDTO
	 * @return string categoryId
	 */
	public function createCategory(CategoryDTO $categoryDTO): string
	{
		$categoryId = Uuid::uuid4()->toString();
		$category = new Category($categoryId, $categoryDTO->name);
		$this->categoryRepository->add($category);
		return $categoryId;
	}
}