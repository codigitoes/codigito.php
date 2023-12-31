<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Doctrine\Mapping\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class IntegerType extends \Doctrine\DBAL\Types\IntegerType
{
    public function getName(): string
    {
        return $this->typeName();
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): object
    {
        $className = $this->typeClassName();

        return new $className((int) $value);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): int
    {
        return $value->value;
    }

    abstract protected function typeName(): string;

    abstract protected function typeClassName(): string;
}
