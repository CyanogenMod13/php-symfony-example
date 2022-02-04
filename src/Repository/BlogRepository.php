<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class BlogRepository
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
        $this->repository = $this->entityManager->getRepository(Blog::class);
    }

	/**
	 * @throws BlogNotFoundException
	 */
	public function get(string $id): Blog
    {
        $blog = $this->repository->find($id);
        if (!$blog) {
            throw new BlogNotFoundException();
        }
        return $blog;
    }

    /**
     * @return Blog[]
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }

	/**
	 * Remove flush()
	 */
    public function add(Blog $blog): void
    {
        $this->entityManager->persist($blog);
        $this->entityManager->flush();
    }

	/**
	 * Remove flush()
	 */
    public function remove(Blog $blog): void
    {
        $this->entityManager->remove($blog);
        $this->entityManager->flush();
    }
}