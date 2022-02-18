<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Types;

use App\Domain\Model\Security\Type\Token;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;

class TokenType extends StringType
{
	public const name = 'user_token';

	public function convertToPHPValue($value, AbstractPlatform $platform): Token
	{
		if (!(is_string($value) || is_null($value))) {
			throw new ConversionException();
		}
		return new Token($value);
	}

	public function convertToDatabaseValue($value, AbstractPlatform $platform): string
	{
		if (!($value instanceof Token)) {
			throw new ConversionException();
		}
		return $value->getToken();
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