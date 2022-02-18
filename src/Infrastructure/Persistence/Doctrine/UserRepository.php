<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\Security\User;
use App\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class UserRepository implements UserRepositoryInterface
{
	private EntityRepository $repository;

	public function __construct(
		private EntityManagerInterface $entityManager
	)
	{
		$this->repository = $entityManager->getRepository(User::class);
	}

	public function get(string $id): User
	{
		$user = $this->repository->find($id);
		if (!$user) {
			throw new UserNotFoundException();
		}
		return $user;
	}

	public function getAll(): array
	{
		return $this->repository->findAll();
	}

	public function findByToken(string $token): User
	{
		$user = $this->repository->findOneBy(['token' => $token]);
		if (!$user) {
			throw new UserNotFoundException();
		}
		return $user;
	}

	public function findByEmail(string $email): User
	{
		$user = $this->repository->findOneBy(['email' => $email]);
		if (!$user) {
			throw new UserNotFoundException();
		}
		return $user;
	}

	public function add(User $user, bool $transactional = false): void
	{
		$this->entityManager->persist($user);
		if (!$transactional) {
			$this->entityManager->flush();
		}
	}

	public function remove(User $user, bool $transactional = false): void
	{
		$this->entityManager->remove($user);
		if (!$transactional) {
			$this->entityManager->flush();
		}
	}
}