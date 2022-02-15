<?php

declare(strict_types=1);

namespace App\Application\Commands;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

class ArticlePublishCommand
{
	#[NotBlank]
	#[Uuid]
	public string $authorId;
	#[NotBlank]
	public string $title;
	#[NotBlank]
	public string $content;
}