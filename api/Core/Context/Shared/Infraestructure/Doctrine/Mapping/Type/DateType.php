<?php

declare(strict_types=1);

namespace Core\Context\Shared\Infraestructure\Doctrine\Mapping\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeTzImmutableType;

abstract class DateType extends DateTimeTzImmutableType
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function getName(): string
    {
        return $this->typeName();
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): object
    {
        $className = $this->typeClassName();

        return new $className((string) $value);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    abstract protected function typeName(): string;

    abstract protected function typeClassName(): string;
}
