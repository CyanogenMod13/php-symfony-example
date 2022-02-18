<?php

declare(strict_types=1);

namespace App\Application\Commands\Handler;

use App\Application\Commands\UserRegisterCommand;
use App\Domain\Model\Blog\Author;
use App\Domain\Model\Blog\AuthorInfo;
use App\Domain\Model\Blog\Type\BlogId;
use App\Domain\Model\Security\Event\UserCreatedEvent;
use App\Domain\Model\Security\User;
use App\Domain\Repository\AuthorRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Service\AccessApiTokenService;
use App\Infrastructure\Persistence\Flusher;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegisterHandler
{
	public function __construct(
		private EventDispatcherInterface $eventDispatcher,
		private UserRepositoryInterface $userRepository,
		private AuthorRepositoryInterface $authorRepository,
		private UserPasswordHasherInterface $hasher,
		private AccessApiTokenService $tokenService,
		private Flusher $flusher
	) {}

	public function handle(UserRegisterCommand $command): array
	{
		$userId = Uuid::uuid4()->toString();

		$token = $this->tokenService->generateToken($command->username . $command->penName);

		/** Begin transaction **/
		$user = new User($userId, $command->username, '');

		$hashedPassword = $this->hasher->hashPassword($user, $command->password);
		$user->setPassword($hashedPassword);

		$user->updateToken($token);
		$this->userRepository->add($user, true);

		$author = new Author(
			BlogId::generate($userId),
			new AuthorInfo($command->firstName, $command->lastName, $command->penName)
		);
		$this->authorRepository->add($author, true);

		$this->flusher->flush();
		/** End transaction **/

		$this->eventDispatcher->dispatch(new UserCreatedEvent($user), UserCreatedEvent::NAME);

		return [
			'user' => $user->getUserIdentifier(),
			'token' => $token
		];
	}
}