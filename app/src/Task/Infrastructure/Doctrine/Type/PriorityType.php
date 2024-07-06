<?php

namespace App\Task\Infrastructure\Doctrine\Type;

use App\Task\Domain\Enum\Priority;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class PriorityType extends Type
{
    private const NAME = 'task_priority';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? Priority::from($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Priority ? $value->value : $value;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): true
    {
        return true;
    }
}
