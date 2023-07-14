<?php

declare(strict_types=1);

namespace Core\Content\Tag\Domain\Repository;

use Core\Content\Tag\Domain\Model\Tag;
use Core\Content\Tag\Domain\ValueObject\TagId;

interface TagWriter
{
    public function create(Tag $tag): void;

    public function delete(TagId $id): void;

    public function update(Tag $tag): void;
}
