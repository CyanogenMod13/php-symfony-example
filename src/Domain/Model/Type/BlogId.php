<?php

declare(strict_types=1);

namespace App\Domain\Model\Type;

use Ramsey\Uuid\Uuid;
use InvalidArgumentException;

class BlogId implements \JsonSerializable
{
	private ?string $value;

	public function __construct(?string $value)
	{
		if (!is_null($value) && !Uuid::isValid($value)) {
			throw new InvalidArgumentException("given invalid uuid string");
		}
		$this->value = $value;
	}

	public function isNullable(): bool
	{
		return is_null($this->value);
	}

	public function setValue(?string $value): void
	{
		if (!is_null($value) && !Uuid::isValid($value)) {
			throw new InvalidArgumentException("given invalid uuid string");
		}
		$this->value = $value;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function equals(BlogId $blogId): bool
	{
		return $this->value === $blogId->value;
	}

	public function __toString(): string
	{
		return "BlogId = $this->value";
	}

	public static function generate(string $id = null): self
	{
		return new BlogId(is_null($id) ? Uuid::uuid4()->toString() : $id);
	}

	public function jsonSerialize()
	{
		return $this->value;
	}
}