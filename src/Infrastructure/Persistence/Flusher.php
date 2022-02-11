<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

interface Flusher
{
	public function flush(): void;
}