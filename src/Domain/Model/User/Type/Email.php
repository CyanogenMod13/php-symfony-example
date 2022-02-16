<?php

declare(strict_types=1);

namespace App\Domain\Model\User\Type;

class Email
{
	private string $email;

	public function __construct(string $email)
	{
		$this->email = $email;
	}

	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	public function getEmail(): string
	{
		return $this->email;
	}
}