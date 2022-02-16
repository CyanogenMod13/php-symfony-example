<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Blog\Blog;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\Exception\BlogNotFoundException;

interface BlogRepositoryInterface
{
	/**
	 * @throws BlogNotFoundException
	 */
	public function get(BlogId $id): Blog;

	/**
	 * @return Blog[]
	 */
	public function getAll(): array;

	public function add(Blog $blog, bool $transactional = false): void;

	public function remove(Blog $blog, bool $transactional = false): void;
}