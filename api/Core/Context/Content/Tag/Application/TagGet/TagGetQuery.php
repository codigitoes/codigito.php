<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Application\TagGet;

use Core\Context\Shared\Domain\Query\Query;

class TagGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
