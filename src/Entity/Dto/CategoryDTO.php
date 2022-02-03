<?php
declare(strict_types=1);

namespace App\Entity\Dto;

use App\Entity\Category;

class CategoryDTO
{
    public function __construct(
        public string $name
    )
    {}

	/**
	 * @param Category $category
	 * @return CategoryDTO
	 */
	public static function toDto(Category $category): CategoryDTO
	{
		return new CategoryDTO($category->getName());
	}
}