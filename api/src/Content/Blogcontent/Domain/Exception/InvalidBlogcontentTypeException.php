<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\Exception;

use Codigito\Shared\Domain\Exception\DomainException;

class InvalidBlogcontentTypeException extends DomainException
{
    public const PREFIX = 'invalid blogcontent type its an internal problem';

    public function __construct()
    {
        parent::__construct(self::PREFIX);
    }

    public const ERROR_CODE = 500;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}