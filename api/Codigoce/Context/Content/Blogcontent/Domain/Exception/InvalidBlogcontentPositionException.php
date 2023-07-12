<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Blogcontent\Domain\Exception;

use Codigoce\Context\Shared\Domain\Exception\DomainException;

class InvalidBlogcontentPositionException extends DomainException
{
    public const PREFIX = 'invalid blogcontent position';

    public function __construct(int $value)
    {
        parent::__construct(self::PREFIX.' '.$value);
    }

    public const ERROR_CODE = 400;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
