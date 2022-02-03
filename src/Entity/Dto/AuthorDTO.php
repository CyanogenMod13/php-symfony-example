<?php
declare(strict_types=1);

namespace App\Entity\Dto;

class AuthorDTO
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $penName
    )
    {}
}