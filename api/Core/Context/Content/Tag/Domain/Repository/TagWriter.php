<?php

declare(strict_types=1);

namespace Core\Context\Content\Tag\Domain\Repository;

use Core\Context\Content\Tag\Domain\Model\Tag;
use Core\Context\Content\Tag\Domain\ValueObject\TagId;

interface TagWriter
{
    public function create(Tag $tag): void;

    public function delete(TagId $id): void;

    public function update(Tag $tag): void;
}
