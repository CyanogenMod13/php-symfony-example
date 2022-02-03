<?php
declare(strict_types=1);

namespace App\Entity\Dto;

use App\Entity\Author;

class AuthorDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $penName
    )
    {}

	public static function toDto(Author $author): AuthorDTO
	{
		return new AuthorDTO(
			$author->getFirstName(),
			$author->getLastName(),
			$author->getPenName()
		);
	}
}