<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Author;
use App\Entity\Blog;
use App\Repository\AuthorNotFoundException;
use App\Repository\AuthorRepository;

class AuthorService
{
	public function __construct(
		private AuthorRepository $authorRepository
	) {}

	/**
	 * @throws AuthorNotFoundException
	 */
	public function getAuthorData(string $authorId): Author
	{
		return $this->authorRepository->get($authorId);
	}

	/**
	 * @return Author[]
	 */
	public function getAllAuthor(): array
	{
		return $this->authorRepository->getAll();
	}

	/**
	 * @throws AuthorNotFoundException
	 */
	public function getBlogByAuthor(string $authorId): Blog
	{
		return $this->authorRepository->get($authorId)->getBlog();
	}
}