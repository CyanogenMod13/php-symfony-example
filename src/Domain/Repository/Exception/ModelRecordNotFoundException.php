<?php

declare(strict_types=1);

namespace App\Domain\Repository\Exception;

use DomainException;
use Throwable;

class ModelRecordNotFoundException extends DomainException
{
	public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}