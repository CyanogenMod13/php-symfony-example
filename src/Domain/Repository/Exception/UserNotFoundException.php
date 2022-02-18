<?php

declare(strict_types=1);

namespace App\Domain\Repository\Exception;

use Throwable;

class UserNotFoundException extends ModelRecordNotFoundException
{
	public function __construct()
	{
		parent::__construct('User not found');
	}
}