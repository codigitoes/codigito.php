<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Domain\Exception;

use Codigito\Shared\Domain\Exception\DomainException;

class InvalidTagIdException extends DomainException
{
    public const PREFIX = 'invalid tag id';

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