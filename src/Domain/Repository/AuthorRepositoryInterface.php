<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Author;
use App\Domain\Model\Type\BlogId;
use App\Domain\Repository\Exception\AuthorNotFoundException;

interface AuthorRepositoryInterface
{
	/**
	 * @throws AuthorNotFoundException
	 */
	public function get(BlogId $id): Author;

	/**
	 * @return Author[]
	 */
	public function getAll(): array;
}