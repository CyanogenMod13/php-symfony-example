<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityNotFoundException;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class ArticleNotFoundException extends EntityNotFoundException
{
	public function __construct()
	{
		parent::__construct('Article not found');
	}
}