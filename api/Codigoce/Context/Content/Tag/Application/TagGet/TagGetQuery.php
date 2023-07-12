<?php

declare(strict_types=1);

namespace Codigoce\Context\Content\Tag\Application\TagGet;

use Codigoce\Context\Shared\Domain\Query\Query;

class TagGetQuery implements Query
{
    public function __construct(
        public readonly string $id
    ) {
    }
}
