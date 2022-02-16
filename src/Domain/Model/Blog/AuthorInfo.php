<?php

declare(strict_types=1);

namespace App\Domain\Model\Blog;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class AuthorInfo
{
	#[ORM\Column]
	private string $firstName;

	#[ORM\Column]
	private string $lastName;

	#[ORM\Column]
	private string $penName;

	/**
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $penName
	 */
	public function __construct(string $firstName, string $lastName, string $penName)
	{
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->penName = $penName;
	}

	/**
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->firstName;
	}

	/**
	 * @return string
	 */
	public function getLastName(): string
	{
		return $this->lastName;
	}

	/**
	 * @return string
	 */
	public function getPenName(): string
	{
		return $this->penName;
	}
}