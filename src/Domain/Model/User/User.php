<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

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

	/*public function __construct(string $id, string $email, array $roles, string $hashedPassword)
	{
		$this->id = $id;
		$this->email = $email;
		$this->roles = $roles;
		$this->password = $hashedPassword;
	}*/

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