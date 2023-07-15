<?php

declare(strict_types=1);

namespace Codigito\Content\Blogcontent\Domain\Model;

use Codigito\Shared\Domain\Model\ReadModel;
use Codigito\Content\Blogcontent\Domain\Exception\InvalidBlogcontentTypeException;

class BlogcontentCollectionReadModel implements ReadModel
{
    public function __construct(
        public readonly array $blogcontents
    ) {
        foreach ($blogcontents as $aBlogcontent) {
            if ($aBlogcontent instanceof Blogcontent) {
                continue;
            }

            throw new InvalidBlogcontentTypeException();
        }
    }

    public function toPrimitives(): array
    {
        $blogcontentsPrimitives = [];
        foreach ($this->blogcontents as $aBlogcontent) {
            $blogcontentsPrimitives[] = $aBlogcontent->toPrimitives();
        }

        return $blogcontentsPrimitives;
    }
}
