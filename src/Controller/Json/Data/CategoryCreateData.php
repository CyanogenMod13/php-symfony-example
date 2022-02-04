<?php

declare(strict_types=1);


namespace App\Controller\Json\Data;

class CategoryCreateData
{
	public function __construct(
		public string $name
	) {}
}