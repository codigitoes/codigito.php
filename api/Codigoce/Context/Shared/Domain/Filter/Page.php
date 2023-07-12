<?php

declare(strict_types=1);

namespace Codigoce\Context\Shared\Domain\Filter;

final class Page
{
    public const FIRST_PAGE = 1;
    public const PAGE_LIMIT = 10;

    public readonly int $offset;

    private function __construct(
        public readonly int $page,
        public readonly int $limit
    ) {
        $this->offset = ($page * $limit) - $limit;
    }

    final public static function from(
        int $page,
        int $limit
    ): static {
        if ((int) $page < 1) {
            $page = self::FIRST_PAGE;
        }
        if ((int) $limit < 1) {
            $limit = self::PAGE_LIMIT;
        }

        return new Page($page, $limit);
    }

    final public static function first25(): static
    {
        return new Page(self::FIRST_PAGE, self::PAGE_LIMIT);
    }

    final public static function page25(int $page): static
    {
        return new Page($page, self::PAGE_LIMIT);
    }

    final public static function one(): static
    {
        return new Page(1, 1);
    }
}
