<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Domain\Model;

use Codigito\Content\Tag\Domain\Exception\InvalidTagTypeException;
use Codigito\Shared\Domain\Model\ReadModel;

class TagCollectionReadModel implements ReadModel
{
    public function __construct(
        public readonly array $tags
    ) {
        foreach ($tags as $aTag) {
            if ($aTag instanceof Tag) {
                continue;
            }

            throw new InvalidTagTypeException();
        }
    }

    public function toPrimitives(): array
    {
        $tagsPrimitives = [];
        foreach ($this->tags as $aTag) {
            $tagsPrimitives[] = $aTag->toPrimitives();
        }

        return $tagsPrimitives;
    }
}
