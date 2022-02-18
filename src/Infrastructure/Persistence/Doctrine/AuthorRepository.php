<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\Blog\Author;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Repository\AuthorRepositoryInterface;
use App\Domain\Repository\Exception\AuthorNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class AuthorRepository implements AuthorRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
        $this->repository = $this->entityManager->getRepository(Author::class);
    }

    /**
     * @throws AuthorNotFoundException
     */
    public function get(BlogId $id): Author
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

	public function add(Author $author, bool $transactional = false): void
	{
		$this->entityManager->persist($author);
		if (!$transactional) {
			$this->entityManager->flush();
		}
	}
}