<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Domain\Exception;

use Codigoce\Context\Shared\Domain\Exception\DomainException;

class InvalidTagUpdateEmptyRequestException extends DomainException
{
    public const PREFIX = 'invalid tag update request, cant be empty';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX.' '.$value);
    }

    public const ERROR_CODE = 400;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
