<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Domain\Exception;

use Core\Context\Shared\Domain\Exception\DomainException;

class InvalidBlogcontentUpdateEmptyRequestException extends DomainException
{
    public const PREFIX = 'invalid blogcontent update request, cant be empty';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX . ' ' . $value);
    }

    public const ERROR_CODE = 400;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
