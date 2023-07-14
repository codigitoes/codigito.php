<?php

declare(strict_types=1);

namespace Core\\Shared\Infraestructure\Doctrine\Mapping\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class BooleanType extends \Doctrine\DBAL\Types\IntegerType
{
    public function getName(): string
    {
        return $this->typeName();
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): object
    {
        $className = $this->typeClassName();

        return new $className((bool) $value);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): int
    {
        return (int) $value->value;
    }

    abstract protected function typeName(): string;

    abstract protected function typeClassName(): string;
}
