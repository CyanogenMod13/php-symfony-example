<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Author;
use App\Domain\Repository\Exception\AuthorNotFoundException;

interface AuthorRepositoryInterface
{
	/**
	 * @throws AuthorNotFoundException
	 */
	public function get(string $id): Author;

	/**
	 * @return Author[]
	 */
	public function getAll(): array;
}