<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Application\TagExistsValidator;

use Codigito\Shared\Domain\Command\Command;

class TagExistsValidatorCommand implements Command
{
    public function __construct(
        public readonly array $names
    ) {
    }
}
