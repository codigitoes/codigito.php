<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Application\BlogpostExistsValidator;

use Codigito\Shared\Domain\Command\Command;

class BlogpostExistsValidatorCommand implements Command
{
    public function __construct(
        public readonly array $ids
    ) {
    }
}
