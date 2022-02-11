<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Types;

use App\Domain\Model\User\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;

class EmailType extends StringType
{
	private const name = 'user_email';

	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if (!($value instanceof Email)) {
			throw new ConversionException();
		}
		return $value->getEmail();
	}

	public function convertToPHPValue($value, AbstractPlatform $platform): Email
	{
		if (!is_string($value)) {
			throw new ConversionException();
		}
		return new Email($value);
	}

	public function requiresSQLCommentHint(AbstractPlatform $platform): bool
	{
		return true;
	}

	public function getName(): string
	{
		return self::name;
	}
}