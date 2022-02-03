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
     * @param string $id
     * @return Blog
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
     * @param Blog $blog
     * @return void
     */
    public function add(Blog $blog): void
    {
        $this->entityManager->persist($blog);
        $this->entityManager->flush();
    }

    /**
     * @param Blog $blog
     * @return void
     */
    public function remove(Blog $blog): void
    {
        $this->entityManager->remove($blog);
        $this->entityManager->flush();
    }
}