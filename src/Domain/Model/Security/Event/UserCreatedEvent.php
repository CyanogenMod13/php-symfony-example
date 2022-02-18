<?php

declare(strict_types=1);

namespace App\Domain\Model\Security\Event;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;

class UserCreatedEvent extends Event
{
	public const NAME = 'user.created';

	public function __construct(
		private UserInterface $user
	) {}

	public function getUser(): UserInterface
	{
		return $this->user;
	}
}