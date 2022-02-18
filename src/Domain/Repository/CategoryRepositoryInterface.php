<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Blog\Category;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\Exception\CategoryNotFoundException;

interface CategoryRepositoryInterface
{
	/**
	 * @throws CategoryNotFoundException
	 */
	public function get(BlogId $id): Category;

	/**
	 * @return Category[]
	 */
	public function getAll(): array;

	public function add(Category $category, bool $transactional = false): void;

	public function remove(Category $category, bool $transactional = false): void;
}