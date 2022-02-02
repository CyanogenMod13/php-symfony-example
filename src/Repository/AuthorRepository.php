<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class AuthorRepository
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
        $this->repository = $this->entityManager->getRepository(Author::class);
    }

    /**
     * @param string $id
     * @return Author
     * @throws AuthorNotFoundException
     */
    public function get(string $id): Author
    {
        $author = $this->repository->find($id);
        if (!$author) {
            throw new AuthorNotFoundException();
        }
        return $author;
    }

    /**
     * @return Author[]
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }
}