<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Article;
use App\Entity\Comment;
use App\Repository\ArticleNotFoundException;
use App\Repository\ArticleRepository;

class ArticleService
{
	public function __construct(
		private ArticleRepository $articleRepository
	) {}

	/**
	 * @throws ArticleNotFoundException
	 */
	public function getArticle(string $articleId): Article
	{
		return $this->articleRepository->get($articleId);
	}

	/**
	 * @return Article[]
	 */
	public function getAllArticle(): array
	{
		return $this->articleRepository->getAll();
	}

	/**
	 * @return Comment[]
	 * @throws ArticleNotFoundException
	 */
	public function getComments(string $articleId): array
	{
		return $this->articleRepository->get($articleId)->getComments();
	}
}