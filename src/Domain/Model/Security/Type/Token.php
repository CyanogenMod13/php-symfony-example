<?php

declare(strict_types=1);

namespace App\Domain\Model\Security\Type;

class Token
{
	private string $token;

	public function __construct(string $token)
	{
		$this->token = $token;
	}

	public function getToken(): string
	{
		return $this->token;
	}

	public function setToken(string $token): void
	{
		$this->token = $token;
	}

	public function equals(?Token $token): bool
	{
		if (is_null($token)) {
			return false;
		}
		return $this->token === $token->token;
	}
}