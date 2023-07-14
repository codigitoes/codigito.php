<?php

declare(strict_types=1);

namespace Core\\Content\Tag\Domain\Model;

use Core\\Content\Tag\Domain\Exception\InvalidTagTypeException;
use Core\\Shared\Domain\Model\ReadModel;

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
