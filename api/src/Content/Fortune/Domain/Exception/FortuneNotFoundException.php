<?php

declare(strict_types=1);

namespace Codigito\Content\Fortune\Domain\Exception;

use Codigito\Shared\Domain\Exception\DomainException;

class FortuneNotFoundException extends DomainException
{
    public const PREFIX = 'fortune not found';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX.' '.$value);
    }

    public const ERROR_CODE = 404;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}