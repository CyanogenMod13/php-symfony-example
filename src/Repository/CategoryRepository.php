<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CategoryRepository
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
        $this->repository = $this->entityManager->getRepository(Category::class);
    }

    /**
     * @param string $id
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function get(string $id): Category
    {
        $category = $this->repository->find($id);
        if (!$category) {
            throw new CategoryNotFoundException();
        }
        return $category;
    }

    /**
     * @return Category[]
     */
    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function add(Category $category, bool $transactional = false): void
    {
        $this->entityManager->persist($category);
		if (!$transactional) {
			$this->entityManager->flush();
		}
    }
}