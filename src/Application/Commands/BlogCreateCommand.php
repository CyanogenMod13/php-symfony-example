<?php

namespace App\Application\Commands;

use App\Domain\Model\Blog\AuthorInfo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class BlogCreateCommand
{
	#[NotBlank]
	#[Uuid]
	public string $userId;
	#[NotBlank]
	public string $name;
	#[NotBlank]
	public string $alias;
	#[NotBlank]
	public string $categoryId;
	#[NotBlank]
	public AuthorInfo $author;
}