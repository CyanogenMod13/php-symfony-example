<?php

declare(strict_types=1);

namespace App\Domain\Model\Security;

use DateInterval;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'user_users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\Column(type: 'guid')]
	#[ORM\Id]
	private string $id;

	#[ORM\Column(length: 180)]
	private string $email;

	#[ORM\Column(type: 'json')]
	private array $roles;

	#[ORM\Column]
	private string $password;

	#[ORM\Column(nullable: true)]
	private ?string $token;

	#[ORM\Column(nullable: true)]
	private ?DateTimeImmutable $tokenExpireAt;

	public function __construct(?string $id, ?string $email, ?string $hashedPassword)
	{
		$this->id = $id;
		$this->email = $email;
		$this->password = $hashedPassword;
		$this->roles = ['ROLE_USER'];
	}

	public function updateToken(string $token): void
	{
		$this->token = $token;
		$now = new DateTimeImmutable();
		$this->tokenExpireAt = $now->add(DateInterval::createFromDateString('7 day'));
	}

	public function getToken(): ?string
	{
		return $this->token;
	}

	public function getTokenExpireAt(): ?DateTimeImmutable
	{
		return $this->tokenExpireAt;
	}

	public function setId(string $id): void
	{
		$this->id = $id;
	}

	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	public function setRoles(array $roles): void
	{
		$this->roles = $roles;
	}

	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function getRoles(): array
	{
		return array_unique($this->roles);
	}

	public function eraseCredentials() {}

	public function getUserIdentifier(): string
	{
		return $this->email;
	}
}