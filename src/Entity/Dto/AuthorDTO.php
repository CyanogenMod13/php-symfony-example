<?php

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