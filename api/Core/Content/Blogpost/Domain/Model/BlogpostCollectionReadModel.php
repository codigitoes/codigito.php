<?php

declare(strict_types=1);

namespace Core\\Content\Blogpost\Domain\Model;

use Core\\Content\Blogpost\Domain\Exception\InvalidBlogpostTypeException;
use Core\\Shared\Domain\Model\ReadModel;

class BlogpostCollectionReadModel implements ReadModel
{
    public function __construct(
        public readonly array $blogposts
    ) {
        foreach ($blogposts as $aBlogpost) {
            if ($aBlogpost instanceof Blogpost) {
                continue;
            }

            throw new InvalidBlogpostTypeException();
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
