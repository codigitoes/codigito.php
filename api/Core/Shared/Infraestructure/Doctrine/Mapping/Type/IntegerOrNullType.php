<?php

declare(strict_types=1);

namespace Core\Shared\Infraestructure\Doctrine\Mapping\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class IntegerOrNullType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $this->typeName();
    }

    public function getName(): string
    {
        return $this->typeName();
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): object
    {
        $className = $this->typeClassName();

        return new $className((int) $value);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?int
    {
        return $value->value;
    }

    abstract protected function typeName(): string;

    abstract protected function typeClassName(): string;
}
