<?php

declare(strict_types=1);

namespace App\Domain\Service;

use Ramsey\Uuid\Uuid;

class AccessApiTokenService
{
	//stub generator
	public function generateToken(string $identity): string
	{
		return sha1($identity . Uuid::uuid4()->toString());
	}
}