<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Blog\Article;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\Exception\ArticleNotFoundException;

interface ArticleRepositoryInterface
{
	/**
	 * @throws ArticleNotFoundException
	 */
	public function get(BlogId $id);

	/**
	 * @return Article[]
	 */
	public function getAll(): array;

	public function add(Article $article, bool $transactional = false): void;

	public function remove(Article $article, bool $transactional = false): void;
}