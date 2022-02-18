<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Security\User;
use App\Domain\Repository\Exception\UserNotFoundException;

interface UserRepositoryInterface
{
	public function add(User $user, bool $transactional = false): void;

	/**
	 * @throws UserNotFoundException
	 */
	public function get(string $id): User;

	public function remove(User $user, bool $transactional = false): void;

	/**
	 * @return User[]
	 */
	public function getAll(): array;

	/**
	 * @throws UserNotFoundException
	 */
	public function findByToken(string $token): User;

	/**
	 * @throws UserNotFoundException
	 */
	public function findByEmail(string $email): User;
}