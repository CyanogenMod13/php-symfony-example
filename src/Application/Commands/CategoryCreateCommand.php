<?php

declare(strict_types=1);


namespace App\Application\Commands;

class CategoryCreateCommand
{
	public function __construct(
		public string $name
	) {}
}