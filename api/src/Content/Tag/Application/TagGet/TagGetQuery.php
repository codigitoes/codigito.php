<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Application\TagGet;

use Codigito\Shared\Domain\Query\Query;

class TagGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
