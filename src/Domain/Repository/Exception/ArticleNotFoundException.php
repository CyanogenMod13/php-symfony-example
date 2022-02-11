<?php

declare(strict_types=1);

namespace App\Domain\Repository\Exception;

class ArticleNotFoundException extends ModelRecordNotFoundException
{
	public function __construct()
	{
		parent::__construct('Article not found');
	}
}