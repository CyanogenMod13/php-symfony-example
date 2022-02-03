<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Dto\AuthorDTO;
use App\Entity\Dto\BlogDTO;
use App\Repository\AuthorNotFoundException;
use App\Repository\AuthorRepository;

class AuthorService
{
	public function __construct(
		private AuthorRepository $authorRepository
	)
	{}

	/**
	 * @param string $authorId
	 * @return AuthorDTO
	 * @throws AuthorNotFoundException
	 */
	public function getAuthorData(string $authorId): AuthorDTO
	{
		$author = $this->authorRepository->get($authorId);
		return AuthorDTO::toDto($author);
	}

	/**
	 * @return AuthorDTO[]
	 */
	public function getAllAuthor(): array
	{
		$authorDTOs = [];
		$authors = $this->authorRepository->getAll();
		foreach ($authors as $author) {
			$authorDTOs[] = AuthorDTO::toDto($author);
		}
		return $authorDTOs;
	}

	/**
	 * @param string $authorId
	 * @return BlogDTO
	 * @throws AuthorNotFoundException
	 */
	public function getBlogByAuthor(string $authorId): BlogDTO
	{
		$author = $this->authorRepository->get($authorId);
		return BlogDTO::toDto($author->getBlog());
	}
}