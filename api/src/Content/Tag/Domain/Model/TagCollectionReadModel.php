<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Domain\Model;

use Codigito\Shared\Domain\Exception\InternalErrorException;
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

            throw new InternalErrorException('invalid tag type its an internal problem');
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
