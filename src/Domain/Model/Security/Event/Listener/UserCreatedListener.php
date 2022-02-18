<?php

declare(strict_types=1);

namespace App\Domain\Model\Security\Event\Listener;

use App\Domain\Model\Security\Event\UserCreatedEvent;

class UserCreatedListener
{
	public function onCreated(UserCreatedEvent $event): void
	{

	}
}