<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Domain\Exception;

use Core\Context\Shared\Domain\Exception\DomainException;

class TagCantDeleteException extends DomainException
{
    public const PREFIX = 'cant delete tag';

    public function __construct(string $value)
    {
        parent::__construct(self::PREFIX . ' ' . $value);
    }

    public const ERROR_CODE = 500;

    public function getErrorCode(): int
    {
        return self::ERROR_CODE;
    }
}
