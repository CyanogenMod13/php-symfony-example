<?php

declare(strict_types=1);


namespace App\Application\Commands;

use Symfony\Component\Validator\Constraints\NotBlank;

class CategoryCreateCommand
{
	#[NotBlank]
	public string $name;
}