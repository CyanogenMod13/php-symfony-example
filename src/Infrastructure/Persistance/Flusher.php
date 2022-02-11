<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistance;

interface Flusher
{
	public function flush(): void;
}