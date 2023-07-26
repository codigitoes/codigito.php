<?php

declare(strict_types=1);

namespace Codigito\Content\Blogpost\Domain\Model;

use Codigito\Shared\Domain\Exception\InternalErrorException;
use Codigito\Shared\Domain\Model\ReadModel;

class BlogpostCollectionReadModel implements ReadModel
{
    public function __construct(
        public readonly array $blogposts
    ) {
        foreach ($blogposts as $aBlogpost) {
            if ($aBlogpost instanceof Blogpost) {
                continue;
            }

            throw new InternalErrorException('invalid blogpost type its an internal problem');
        }
    }

    public function toPrimitives(): array
    {
        $blogpostsPrimitives = [];
        foreach ($this->blogposts as $aBlogpost) {
            $blogpostsPrimitives[] = $aBlogpost->toPrimitives();
        }

        return $blogpostsPrimitives;
    }
}
