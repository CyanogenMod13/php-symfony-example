<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ArticleRepository
{
	private EntityRepository $repository;

	public function __construct(
		private EntityManagerInterface $entityManager
	)
	{
		$this->repository = $this->entityManager->getRepository(Article::class);
	}

	/**
	 * @throws ArticleNotFoundException
	 */
	public function get(string $id): Article
	{
		$article = $this->repository->find($id);
		if (!$article) {
			throw new ArticleNotFoundException();
		}
		return $article;
	}

	/**
	 * @return Article[]
	 */
	public function getAll(): array
	{
		return $this->repository->findAll();
	}

	/**
	 * Remove flush()
	 */
	public function add(Article $article): void
	{
		$this->entityManager->persist($article);
		$this->entityManager->flush();
	}

	/**
	 * Remove flush()
	 */
	public function remove(Article $article): void
	{
		$this->entityManager->remove($article);
		$this->entityManager->flush();
	}
}