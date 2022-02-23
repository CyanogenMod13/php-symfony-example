<?php

declare(strict_types=1);

namespace App\Application\Commands;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class ArticleEditCommand
{
	#[NotBlank]
	public string $title;
	#[NotBlank]
	public string $content;
	#[NotBlank]
	#[Uuid]
	public string $articleId;
	#[NotBlank]
	#[Uuid]
	public string $authorId;
}