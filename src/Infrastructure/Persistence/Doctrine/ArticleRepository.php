<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\Blog\Article;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\ArticleRepositoryInterface;
use App\Domain\Repository\Exception\ArticleNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ArticleRepository implements ArticleRepositoryInterface
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
	public function get(BlogId $id): Article
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
	public function add(Article $article, bool $transactional = false): void
	{
		$this->entityManager->persist($article);
		if (!$transactional) {
			$this->entityManager->flush();
		}
	}

	/**
	 * Remove flush()
	 */
	public function remove(Article $article, bool $transactional = false): void
	{
		$this->entityManager->remove($article);
		if (!$transactional) {
			$this->entityManager->flush();
		}
	}
}