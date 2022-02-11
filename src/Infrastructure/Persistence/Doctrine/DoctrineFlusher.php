<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Infrastructure\Persistence\Flusher;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineFlusher implements Flusher
{
	public function __construct(
		private EntityManagerInterface $entityManager
	) {}

	public function flush(): void
	{
		$this->entityManager->flush();
	}
}