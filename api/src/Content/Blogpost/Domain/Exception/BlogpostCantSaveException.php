<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\Exception;

use Codigito\Shared\Domain\Exception\DomainException;

class BlogpostCantSaveException extends DomainException
{
    public const PREFIX = 'cant create a new blogpost';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX.' '.$value);
    }

    public const ERROR_CODE = 500;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}