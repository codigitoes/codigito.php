<?php

declare(strict_types=1);

namespace Codigito\Content\Tag\Domain\Repository;

use Codigito\Content\Tag\Domain\Model\Tag;
use Codigito\Content\Tag\Domain\ValueObject\TagId;

interface TagWriter
{
    public function create(Tag $tag): void;

    public function delete(TagId $id): void;

    public function update(Tag $tag): void;
}
