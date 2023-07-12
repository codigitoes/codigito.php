<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Domain\Exception;

use Codigoce\Context\Shared\Domain\Exception\DomainException;

class BlogcontentCantSaveException extends DomainException
{
    public const PREFIX = 'cant create a new blogcontent';

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
