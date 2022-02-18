<?php

declare(strict_types=1);

namespace App\Application\Commands;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegisterCommand
{
	#[NotBlank]
	#[Email]
	public string $username;
	#[NotBlank]
	#[Length(min: 8)]
	public string $password;
	#[NotBlank]
	public string $firstName;
	#[NotBlank]
	public string $lastName;
	#[NotBlank]
	public string $penName;
}