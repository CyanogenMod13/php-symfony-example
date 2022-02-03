<?php
declare(strict_types=1);

namespace App\Entity\Dto;

use App\Entity\Blog;

class BlogDTO
{
    public function __construct(
        public string $name,
        public string $alias,
        public AuthorDTO $author,
        public CategoryDTO $category
    )
    {}

	/**
	 * @param Blog $blog
	 * @return BlogDTO
	 */
	public static function toDto(Blog $blog): BlogDTO
	{
		$author = $blog->getAuthor();
		$category = $blog->getCategory();
		return new BlogDTO(
			$blog->getName(),
			$blog->getAlias(),
			new AuthorDTO(
				$author->getFirstName(),
				$author->getLastName(),
				$author->getPenName()
			),
			new CategoryDTO(
				$category->getName()
			)
		);
	}
}