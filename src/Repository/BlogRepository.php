<?php

namespace App\Repository;

use App\Entity\Author;
use App\Entity\Blog;
use App\Entity\Category;
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
/*
    public function getByAuthor(Author $author): Blog
    {
    }

    public function getByCategory(Category $category): array
    {
    }
*/
    /**
     * @param Blog $blog
     * @return void
     */
    public function add(Blog $blog): void
    {
        $this->entityManager->persist($blog);
        $this->entityManager->flush();
    }

    public function remove(Blog $blog): void
    {
        $this->entityManager->remove($blog);
        $this->entityManager->flush();
    }
}