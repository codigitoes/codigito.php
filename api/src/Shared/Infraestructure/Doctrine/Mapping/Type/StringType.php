<?php

declare(strict_types=1);

namespace Codigito\Shared\Infraestructure\Doctrine\Mapping\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class StringType extends \Doctrine\DBAL\Types\StringType
{
    public function getName(): string
    {
        return $this->typeName();
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): object
    {
        $className = $this->typeClassName();

        return new $className($value);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): string
    {
        return $value->value;
    }

    abstract protected function typeName(): string;

    abstract protected function typeClassName(): string;
}
