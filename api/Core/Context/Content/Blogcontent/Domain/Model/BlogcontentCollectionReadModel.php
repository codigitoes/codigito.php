<?php

declare(strict_types=1);

namespace Core\Context\Content\Blogcontent\Domain\Model;

use Core\Context\Shared\Domain\Model\ReadModel;
use Core\Context\Content\Blogcontent\Domain\Exception\InvalidBlogcontentTypeException;

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
