<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\Blog\Blog;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\BlogRepositoryInterface;
use App\Domain\Repository\Exception\BlogNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class BlogRepository implements BlogRepositoryInterface
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
	public function get(BlogId $id): Blog
    {
        $blog = $this->repository->find($id);
        if (!$blog) {
            throw new BlogNotFoundException();
        }
        return $blog;
    }

    /**
     * @return \App\Domain\Model\Blog\Blog[]
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }

	/**
	 * Remove flush()
	 */
    public function add(Blog $blog, bool $transactional = false): void
    {
        $this->entityManager->persist($blog);
		if (!$transactional) {
			$this->entityManager->flush();
		}
    }

	/**
	 * Remove flush()
	 */
    public function remove(Blog $blog, bool $transactional = false): void
    {
        $this->entityManager->remove($blog);
		if (!$transactional) {
			$this->entityManager->flush();
		}
    }
}