<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\Blog\Category;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\Repository\Exception\CategoryNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Polyfill\Intl\Icu\Exception\MethodNotImplementedException;

class CategoryRepository implements CategoryRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
        $this->repository = $this->entityManager->getRepository(Category::class);
    }

    /**
     * @throws CategoryNotFoundException
     */
    public function get(BlogId $id): Category
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

	public function remove(Category $category, bool $transactional = false): void
	{
		throw new MethodNotImplementedException('remove');
	}
}