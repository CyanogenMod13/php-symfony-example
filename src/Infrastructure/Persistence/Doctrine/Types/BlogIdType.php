<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Types;

use App\Domain\Model\Blog\Type\BlogId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\GuidType;

class BlogIdType extends GuidType
{
	private const name = 'blog_id';

	public function getName(): string
	{
		return self::name;
	}

	public function requiresSQLCommentHint(AbstractPlatform $platform): bool
	{
		return true;
	}

	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if (!($value instanceof BlogId)) {
			throw new ConversionException("expected BlogId, given \"$value\"");
		}
		return $value->getValue();
	}

	public function convertToPHPValue($value, AbstractPlatform $platform): BlogId
	{
		// not(a) and not(b) == not(a or b)
		if (!is_null($value) && !is_string($value)) {
			throw new ConversionException("expected string or null, given \"$value\"");
		}
		return new BlogId($value);
	}
}